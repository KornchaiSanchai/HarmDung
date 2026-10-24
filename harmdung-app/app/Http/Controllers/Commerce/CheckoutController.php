<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use App\Models\AccountStock;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    private function selectedItems(Request $request)
    {
        $ids = array_filter((array) $request->input('items', []));

        return $request->user()->cartProducts()
            ->with('platform')
            ->when($ids, fn ($q) => $q->whereIn('products.id', $ids))
            ->get();
    }

    public function index(Request $request, CouponService $couponService)
    {
        $user = $request->user();
        $cartItems = $this->selectedItems($request);

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'กรุณาเลือกสินค้าที่ต้องการชำระเงินอย่างน้อย 1 รายการ');
        }

        $subtotal = $cartItems->sum(fn ($i) => $i->price * $i->pivot->quantity);
        $discountAmount = 0;
        $total = $subtotal;
        $couponError = null;
        $availableCoupons = Coupon::all();

        $couponCode = $request->input('coupon_code') ?: $request->input('selected_coupon');

        if ($couponCode) {
            $check = $couponService->validate($couponCode, $user, $cartItems);

            if (! ($check['valid'] ?? false)) {
                $couponError = $check['message'] ?? 'คูปองไม่ถูกต้อง';
            } else {
                $applied = $couponService->apply($couponCode, $cartItems);
                $discountAmount = $applied['discount'] ?? 0;
                $total = $applied['total'] ?? $subtotal;
            }
        }

        $selectedIds = $cartItems->pluck('id')->all();

        return view('checkout', compact(
            'cartItems', 'subtotal', 'discountAmount', 'total',
            'couponCode', 'couponError', 'availableCoupons', 'selectedIds'
        ));
    }

    public function process(Request $request, CouponService $couponService)
    {
        $user = $request->user();
        $cartItems = $this->selectedItems($request);
        $selectedIds = array_filter((array) $request->input('items', []));

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'ไม่มีสินค้าในตะกร้าสำหรับชำระเงิน');
        }

        $couponCode = $request->input('coupon_code') ?: $request->input('selected_coupon');

        try {
            $order = DB::transaction(function () use ($user, $cartItems, $couponCode, $couponService) {
                $itemsToProcess = [];

                // 1) ล็อกและตรวจสต็อก + บัญชีพร้อมขาย
                foreach ($cartItems as $item) {
                    $product = Product::whereKey($item->id)->lockForUpdate()->firstOrFail();
                    $qty = $item->pivot->quantity;

                    

                    $accounts = AccountStock::where('product_id', $product->id)
                        ->where('status', 'available')
                        ->lockForUpdate()
                        ->limit($qty)
                        ->get();

                    if ($accounts->count() < $qty) {
                        throw new \Exception("สินค้า {$product->plan_name} มีจำนวนบัญชีพร้อมส่งมอบไม่เพียงพอ");
                    }

                    $itemsToProcess[] = ['product' => $product, 'qty' => $qty, 'accounts' => $accounts];
                }

                // 2) คำนวณราคา + คูปอง
                $subtotal = $cartItems->sum(fn ($i) => $i->price * $i->pivot->quantity);
                $discountAmount = 0;
                $total = $subtotal;
                $coupon = null;

                if ($couponCode) {
                    $check = $couponService->validate($couponCode, $user, $cartItems);
                    if (! ($check['valid'] ?? false)) {
                        throw new \Exception($check['message'] ?? 'คูปองไม่ถูกต้อง');
                    }

                    $applied = $couponService->apply($couponCode, $cartItems);
                    $coupon = $applied['coupon'] ?? Coupon::where('code', $couponCode)->first();
                    $discountAmount = $applied['discount'] ?? 0;
                    $total = $applied['total'] ?? $subtotal;
                }

                // 3) หักเงิน (ล็อกแถวผู้ใช้)
                $lockedUser = User::whereKey($user->id)->lockForUpdate()->first();
                if ($lockedUser->balance < $total) {
                    throw new \Exception('ยอดเงินคงเหลือไม่เพียงพอ');
                }
                $lockedUser->decrement('balance', $total);

                // 4) สร้าง order
                $order = Order::create([
                    'user_id'         => $user->id,
                    'coupon_id'       => $coupon?->id,
                    'subtotal'        => $subtotal,
                    'discount_amount' => $discountAmount,
                    'total'           => $total,
                    'status'          => 'paid',
                ]);

                // 5) order_items + ผูกบัญชี + ตัดสต็อก
                foreach ($itemsToProcess as $p) {
                    $order->products()->attach($p['product']->id, [
                        'quantity'   => $p['qty'],
                        'unit_price' => $p['product']->price,
                    ]);

                    foreach ($p['accounts'] as $account) {
                        $account->update(['order_id' => $order->id, 'status' => 'sold']);
                    }

                
                }

                // 6) บันทึกการใช้คูปอง
                if ($coupon) {
                    $couponService->recordUsage($coupon, $user, $order);
                }

                // 7) ล้างเฉพาะสินค้าที่ซื้อ
                $user->cartProducts()->detach($cartItems->pluck('id')->all());

                return $order;
            });

            return redirect()->route('payment.success', $order)
                ->with('success', 'สั่งซื้อสินค้าเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return redirect()->route('checkout.index', ['items' => $selectedIds])
                ->with('error', $e->getMessage());
        }
    }
}