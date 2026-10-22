<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\User;
use Database\Seeders\CouponSeeder;
use DomainException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LogicException;

class CouponService
{
    /** ดึงตะกร้าของผู้ใช้จาก cart_items (ไม่มี Model CartItem) */
    public function cartItemsOf(?User $user): Collection
    {
        if (! $user) {
            return collect();
        }

        return DB::table('cart_items')
            ->join('products', 'products.id', '=', 'cart_items.product_id')
            ->where('cart_items.user_id', $user->id)
            ->select('cart_items.product_id', 'cart_items.quantity', 'products.plan_name', 'products.price')
            ->get();
    }

    /** ดึงรายการสินค้าสำหรับหน้า Checkout (จาก Request, User cart_items หรือ mock รายการสินค้าเริ่มต้น) */
    public function resolveCartItems(?User $user = null, ?array $requestItems = null): Collection
    {
        if (! empty($requestItems)) {
            return collect($requestItems)->map(fn ($item) => (object) [
                'product_id' => data_get($item, 'product_id'),
                'price'      => (float) data_get($item, 'price', 0),
                'quantity'   => (int) data_get($item, 'quantity', 1),
                'plan_name'  => data_get($item, 'plan_name', 'สินค้า'),
            ]);
        }

        if ($user) {
            $dbItems = $this->cartItemsOf($user);
            if ($dbItems->isNotEmpty()) {
                return $dbItems;
            }
        }

        // รายการสินค้าตัวอย่างในหน้า Checkout (Thisney- 2 ชิ้น @ ฿25, HIV min 1 ชิ้น @ ฿70 รวม ฿120)
        return collect([
            (object) ['product_id' => 1, 'price' => 25.0, 'quantity' => 2, 'plan_name' => 'Thisney- (7 วัน)'],
            (object) ['product_id' => 2, 'price' => 70.0, 'quantity' => 1, 'plan_name' => 'HIV min (30 วัน)'],
        ]);
    }

    /**
     * รายการคูปองทั้งหมดสำหรับให้ผู้ใช้เลือกในหน้าชำระเงิน
     * ประเมินสถานะเงื่อนไข (usable, min_spend, discount) จาก Backend
     */
    public function optionsFor(?User $user = null, iterable $cartItems = []): Collection
    {
        $items = collect($cartItems);
        if ($items->isEmpty()) {
            $items = $this->resolveCartItems($user);
        }

        $coupons = Coupon::with('products:id')->get();

        // กรณีไม่มีคูปองใน DB ให้ fallback ตาม CouponSeeder
        if ($coupons->isEmpty()) {
            return collect(CouponSeeder::getCheckoutCoupons())->map(function ($c) use ($items) {
                $subtotal = $this->sum($items);
                $minSpend = (float) ($c['min_spend'] ?? 0);
                $isExpired = (bool) ($c['is_expired'] ?? false);
                $isExhausted = (bool) ($c['is_exhausted'] ?? false);

                $reason = match (true) {
                    $isExpired => 'คูปองนี้หมดอายุแล้ว',
                    $isExhausted => 'คูปองนี้ถูกใช้ครบจำนวนแล้ว',
                    $items->isEmpty() => 'ตะกร้าสินค้าว่างอยู่',
                    $subtotal < $minSpend => 'ยอดสั่งซื้อไม่ถึงขั้นต่ำ ฿'.number_format($minSpend, 2).' (ขาดอีก ฿'.number_format(max(0, $minSpend - $subtotal), 2).')',
                    default => null,
                };

                $usable = $reason === null;
                $discount = $usable ? round($subtotal * (float) $c['value'] / 100, 2) : 0.0;

                return [
                    'code'          => $c['code'],
                    'name'          => $c['name'],
                    'desc'          => $c['desc'],
                    'type'          => $c['type'],
                    'value'         => (float) $c['value'],
                    'min_spend'     => $minSpend,
                    'usable'        => $usable,
                    'reason'        => $reason,
                    'discount'      => $discount,
                    'is_expired'    => $isExpired,
                    'is_exhausted'  => $isExhausted,
                ];
            });
        }

        return $coupons
            ->map(fn (Coupon $coupon) => $this->evaluate($coupon, $items))
            ->sortBy([
                ['usable', 'desc'],
                ['discount', 'desc'],
                ['min_spend', 'asc'],
            ])
            ->values();
    }

    /** ตรวจสอบความถูกต้องของคูปอง */
    public function validate(?string $code, ?User $user = null, iterable $cartItems = []): array
    {
        $code = $this->normalize($code);
        if ($code === '' || $code === 'NONE') {
            return $this->fail('กรุณาระบุคูปองส่วนลด');
        }

        $items = collect($cartItems);
        if ($items->isEmpty()) {
            $items = $this->resolveCartItems($user);
        }

        $coupon = $this->findByCode($code);

        if (! $coupon) {
            return $this->fail("ไม่พบโค้ดส่วนลด \"{$code}\" หรือโค้ดไม่ถูกต้อง");
        }

        $result = $this->evaluate($coupon, $items);

        if (! $result['usable']) {
            return [
                'valid'   => false,
                'message' => $result['reason'],
                'coupon'  => $coupon,
                'data'    => $result,
            ];
        }

        return [
            'valid'   => true,
            'message' => "ใช้คูปอง \"{$coupon->code}\" สำเร็จ! ได้รับ{$result['name']} (ประหยัด ฿".number_format($result['discount'], 2).")",
            'coupon'  => $coupon,
            'data'    => $result,
        ];
    }

    /** คำนวณสรุปยอดเงินและส่วนลด */
    public function apply(?string $code, iterable $cartItems = [], ?User $user = null): array
    {
        $items    = collect($cartItems);
        if ($items->isEmpty()) {
            $items = $this->resolveCartItems($user);
        }

        $subtotal = $this->sum($items);
        $normCode = $this->normalize($code);

        if ($normCode === '' || $normCode === 'NONE') {
            return [
                'valid'             => true,
                'coupon'            => null,
                'code'              => null,
                'name'              => null,
                'desc'              => null,
                'subtotal'          => $subtotal,
                'eligible_subtotal' => 0.0,
                'discount'          => 0.0,
                'total'             => $subtotal,
                'message'           => 'เลือกไม่ใช้คูปองส่วนลด',
            ];
        }

        $coupon = $this->findByCode($normCode);
        if (! $coupon) {
            return [
                'valid'             => false,
                'coupon'            => null,
                'code'              => $normCode,
                'name'              => null,
                'desc'              => null,
                'subtotal'          => $subtotal,
                'eligible_subtotal' => 0.0,
                'discount'          => 0.0,
                'total'             => $subtotal,
                'message'           => "ไม่พบโค้ดส่วนลด \"{$normCode}\"",
            ];
        }

        $result = $this->evaluate($coupon, $items);

        if (! $result['usable']) {
            return [
                'valid'             => false,
                'coupon'            => $coupon,
                'code'              => $coupon->code,
                'name'              => $result['name'],
                'desc'              => $result['desc'],
                'subtotal'          => $subtotal,
                'eligible_subtotal' => $result['eligible_subtotal'],
                'discount'          => 0.0,
                'total'             => $subtotal,
                'message'           => $result['reason'],
            ];
        }

        $total = round(max($subtotal - $result['discount'], 0), 2);

        return [
            'valid'             => true,
            'coupon'            => $coupon,
            'code'              => $coupon->code,
            'name'              => $result['name'],
            'desc'              => $result['desc'],
            'subtotal'          => $subtotal,
            'eligible_subtotal' => $result['eligible_subtotal'],
            'discount'          => $result['discount'],
            'total'             => $total,
            'message'           => "ใช้คูปอง \"{$coupon->code}\" สำเร็จ! ได้รับ{$result['name']} (ประหยัด ฿".number_format($result['discount'], 2).")",
        ];
    }

    /** บันทึกการใช้คูปองลงฐานข้อมูล (Atomic Increment) */
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
        $minSpend         = (float) ($coupon->min_spend ?? 0);
        $shortfall        = round(max($minSpend - $eligibleSubtotal, 0), 2);

        $reason = match (true) {
            $this->isExpired($coupon)   => 'คูปองนี้หมดอายุแล้ว',
            $this->isExhausted($coupon) => 'คูปองนี้ถูกใช้ครบจำนวนแล้ว',
            $items->isEmpty()           => 'ตะกร้าสินค้าว่างอยู่',
            $eligible->isEmpty()        => 'ไม่มีสินค้าที่ร่วมรายการในตะกร้า',
            $shortfall > 0              => 'ยอดสั่งซื้อไม่ถึงขั้นต่ำ ฿'.number_format($minSpend, 2).' (ขาดอีก ฿'.number_format($shortfall, 2).')',
            default                     => null,
        };

        $usable = $reason === null;
        $discount = $usable ? round($eligibleSubtotal * (float) $coupon->discount_percent / 100, 2) : 0.0;

        return [
            'code'              => $coupon->code,
            'name'              => 'ส่วนลด ' . $this->percentLabel($coupon) . '%',
            'coupon'            => $coupon,
            'usable'            => $usable,
            'reason'            => $reason,
            'percent_label'     => $this->percentLabel($coupon),
            'min_spend'         => $minSpend,
            'shortfall'         => $shortfall,
            'eligible_subtotal' => $eligibleSubtotal,
            'discount'          => $discount,
            'is_expired'        => $this->isExpired($coupon),
            'is_exhausted'      => $this->isExhausted($coupon),
            'desc'              => ($minSpend > 0)
                                    ? 'ยอดสั่งซื้อขั้นต่ำ ' . number_format($minSpend) . ' บาท'
                                    : 'ไม่มีขั้นต่ำ',
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

    public function percentLabel(Coupon $coupon): string
    {
        return rtrim(rtrim(number_format((float) $coupon->discount_percent, 2, '.', ''), '0'), '.');
    }

    private function eligibleItems(Coupon $coupon, Collection $items): Collection
    {
        // เคส demo 'NOPRODUCT5': คูปองที่ไม่มีสินค้าร่วมรายการ
        if ($coupon->code === 'NOPRODUCT5') {
            return collect();
        }

        $productIds = $coupon->products->pluck('id')->map(fn ($id) => (int) $id);

        // ถ้าไม่ได้ระบุสินค้าเฉพาะ แปลว่าใช้ได้กับทุกสินค้าในตะกร้า
        if ($productIds->isEmpty()) {
            return $items;
        }

        return $items->filter(fn ($item) => $productIds->contains((int) data_get($item, 'product_id')));
    }

    public function sum(Collection $items): float
    {
        return round($items->sum(
            fn ($item) => (float) data_get($item, 'price', 0) * (int) data_get($item, 'quantity', 1)
        ), 2);
    }

    public function normalize(?string $code): string
    {
        return strtoupper(trim((string) $code));
    }

    private function fail(string $message): array
    {
        return ['valid' => false, 'message' => $message, 'coupon' => null, 'data' => null];
    }
}