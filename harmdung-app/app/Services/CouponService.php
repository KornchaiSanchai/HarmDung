<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\User;
use DomainException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LogicException;

class CouponService
{
    /** ดึงตะกร้าของผู้ใช้จาก cart_items (ไม่มี Model CartItem) */
    public function cartItemsOf(User $user): Collection
    {
        return DB::table('cart_items')
            ->join('products', 'products.id', '=', 'cart_items.product_id')
            ->where('cart_items.user_id', $user->id)
            ->select('cart_items.product_id', 'cart_items.quantity', 'products.plan_name', 'products.price')
            ->get();
    }

    /**
     * รายการคูปองที่ยังไม่หมดอายุและยังใช้ไม่ครบ สำหรับให้ผู้ใช้เลือกในหน้าชำระเงิน
     * เรียงให้คูปองที่ใช้ได้และลดได้มากอยู่บนสุด
     */
    public function optionsFor(User $user, iterable $cartItems): Collection
    {
        $items = collect($cartItems);

        return Coupon::with('products:id')
            ->whereDate('expiry_date', '>=', today())
            ->whereColumn('used_count', '<', 'usage_limit')
            ->get()
            ->map(fn (Coupon $coupon) => $this->evaluate($coupon, $items))
            ->sortBy([['usable', 'desc'], ['discount', 'desc'], ['min_spend', 'asc']])
            ->values();
    }

    /** @return array{valid: bool, message: string, coupon: ?Coupon} */
    public function validate(?string $code, User $user, iterable $cartItems): array
    {
        if ($this->normalize($code) === '') {
            return $this->fail('กรุณาเลือกคูปอง');
        }

        $coupon = $this->findByCode($code);

        if (! $coupon) {
            return $this->fail('ไม่พบคูปองนี้');
        }

        $result = $this->evaluate($coupon, collect($cartItems));

        if (! $result['usable']) {
            return $this->fail($result['reason']);
        }

        return [
            'valid'   => true,
            'message' => "ใช้คูปอง {$coupon->code} ลด {$result['percent_label']}%",
            'coupon'  => $coupon,
        ];
    }

    /** สรุปยอดเงิน ถ้าไม่ได้เลือกคูปองหรือคูปองใช้ไม่ได้ ส่วนลดจะเป็น 0 */
    public function apply(?string $code, iterable $cartItems): array
    {
        $items    = collect($cartItems);
        $subtotal = $this->sum($items);
        $coupon   = $this->normalize($code) !== '' ? $this->findByCode($code) : null;
        $result   = $coupon ? $this->evaluate($coupon, $items) : null;

        if (! $result || ! $result['usable']) {
            return [
                'coupon'            => null,
                'subtotal'          => $subtotal,
                'eligible_subtotal' => 0.0,
                'discount'          => 0.0,
                'total'             => $subtotal,
            ];
        }

        return [
            'coupon'            => $coupon,
            'subtotal'          => $subtotal,
            'eligible_subtotal' => $result['eligible_subtotal'],
            'discount'          => $result['discount'],
            'total'             => round(max($subtotal - $result['discount'], 0), 2),
        ];
    }

    /**
     * อิ้งต้องเรียกภายใน DB::transaction หลังสร้าง order
     * เพิ่ม used_count แบบ atomic เพื่อกันการใช้เกิน usage_limit เมื่อมีคนกดพร้อมกัน
     *
     * @throws DomainException เมื่อคูปองหมดอายุหรือใช้ครบแล้ว (transaction จะ rollback)
     */
    public function recordUsage(Coupon $coupon, User $user, Order $order): void
    {
        if (DB::transactionLevel() === 0) {
            throw new LogicException('recordUsage ต้องถูกเรียกภายใน DB::transaction');
        }

        $updated = Coupon::whereKey($coupon->id)
            ->whereColumn('used_count', '<', 'usage_limit')
            ->whereDate('expiry_date', '>=', today())
            ->increment('used_count');

        if ($updated === 0) {
            throw new DomainException('คูปองหมดอายุหรือถูกใช้ครบจำนวนแล้ว');
        }

        if ((int) $order->coupon_id !== $coupon->id) {
            $order->update(['coupon_id' => $coupon->id]);
        }
    }

    // ---------- helpers ----------

    /** ตรวจคูปอง 1 ใบกับตะกร้า และคำนวณส่วนลด */
    public function evaluate(Coupon $coupon, Collection $items): array
    {
        $eligible         = $this->eligibleItems($coupon, $items);
        $eligibleSubtotal = $this->sum($eligible);
        $minSpend         = (float) $coupon->min_spend;
        // ถ้าต้องการนับยอดขั้นต่ำจากยอดทั้งตะกร้า ให้เปลี่ยน $eligibleSubtotal ในบรรทัดนี้เป็น $this->sum($items)
        $shortfall        = round(max($minSpend - $eligibleSubtotal, 0), 2);

        $reason = match (true) {
            $this->isExpired($coupon)   => 'คูปองนี้หมดอายุแล้ว',
            $this->isExhausted($coupon) => 'คูปองนี้ถูกใช้ครบจำนวนแล้ว',
            $items->isEmpty()           => 'ตะกร้าสินค้าว่างอยู่',
            $eligible->isEmpty()        => 'ไม่มีสินค้าที่ร่วมรายการในตะกร้า',
            $shortfall > 0              => 'ซื้อสินค้าที่ร่วมรายการเพิ่มอีก ฿'.number_format($shortfall, 2).' จึงจะใช้ได้',
            default                     => null,
        };

        $usable = $reason === null;

        return [
            'coupon'            => $coupon,
            'usable'            => $usable,
            'reason'            => $reason,
            'percent_label'     => $this->percentLabel($coupon),
            'min_spend'         => $minSpend,
            'shortfall'         => $shortfall,
            'eligible_subtotal' => $eligibleSubtotal,
            'discount'          => $usable ? round($eligibleSubtotal * (float) $coupon->discount_percent / 100, 2) : 0.0,
        ];
    }

    public function findByCode(?string $code): ?Coupon
    {
        return Coupon::with('products:id')
            ->where('code', $this->normalize($code))
            ->first();
    }

    public function isExpired(Coupon $coupon): bool
    {
        return $coupon->expiry_date->copy()->endOfDay()->isPast();
    }

    public function isExhausted(Coupon $coupon): bool
    {
        return $coupon->used_count >= $coupon->usage_limit;
    }

    /** "10.00" → "10", "12.50" → "12.5" */
    public function percentLabel(Coupon $coupon): string
    {
        return rtrim(rtrim(number_format((float) $coupon->discount_percent, 2, '.', ''), '0'), '.');
    }

    /** ลดได้เฉพาะสินค้าที่ผูกกับคูปองใน coupon_product */
      /** ลดได้เฉพาะสินค้าที่ผูกกับคูปองใน coupon_product */
    private function eligibleItems(Coupon $coupon, Collection $items): Collection
    {
        $productIds = $coupon->products->pluck('id')->map(fn ($id) => (int) $id);

        return $items->filter(fn ($item) => $productIds->contains($this->productIdOf($item)));
    }

    private function sum(Collection $items): float
    {
        return round($items->sum(
            fn ($item) => (float) data_get($item, 'price', 0) * $this->quantityOf($item)
        ), 2);
    }

    private function productIdOf($item): int
    {
        return (int) (data_get($item, 'product_id') ?? data_get($item, 'id'));
    }

    private function quantityOf($item): int
    {
        return (int) (data_get($item, 'quantity') ?? data_get($item, 'pivot.quantity', 1));
    }

    private function normalize(?string $code): string
    {
        return strtoupper(trim((string) $code));
    }

    private function fail(string $message): array
    {
        return ['valid' => false, 'message' => $message, 'coupon' => null];
    }
}