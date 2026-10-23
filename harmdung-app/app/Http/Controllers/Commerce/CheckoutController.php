<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use App\Models\AccountStock;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // สินค้าในตะกร้าที่ติ๊กเลือก (ถ้าไม่ส่ง items[] มาให้ใช้ทั้งตะกร้า)
    private function selectedItems(Request $request)
    {
        $ids = array_filter((array) $request->input('items', []));

        return $request->user()->cartProducts()
            ->with('platform')
            ->when($ids, fn ($q) => $q->whereIn('products.id', $ids))
            ->get();
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $cartItems = $this->selectedItems($request);

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'ไม่มีสินค้าในตะกร้า');
        }

        $couponService = new CouponService();
        $couponCode = $request->input('coupon_code');
        $applied = $couponService->apply($couponCode, $cartItems);

        $couponError = null;
        if ($couponCode && ! $applied['coupon']) {
            $validation = $couponService->validate($couponCode, $user, $cartItems);
            $couponError = $validation['message'] ?? 'คูปองไม่ถูกต้อง';
        }

        return view('checkout', [
            'cartItems'      => $cartItems,
            'subtotal'       => $applied['subtotal'],
            'discountAmount' => $applied['discount'],
            'total'          => $applied['total'],
            'couponCode'     => $couponCode,
            'couponError'    => $couponError,
            'selectedIds'    => $cartItems->pluck('id')->all(),
        ]);
    }

    public function process(Request $request)
    {
        $user = $request->user();
        $cartItems = $this->selectedItems($request);

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'ไม่มีสินค้าในตะกร้า');
        }

        $couponService = new CouponService();

        try {
            $order = DB::transaction(function () use ($user, $cartItems, $request, $couponService) {
                $itemsToProcess = [];

                // 1) ล็อกและตรวจสต็อก
                foreach ($cartItems as $item) {
                    $product = Product::whereKey($item->id)->lockForUpdate()->firstOrFail();
                    $qty = $item->pivot->quantity;

                    if ($product->stock < $qty) {
                        throw new \Exception("สต็อก {$product->plan_name} ไม่เพียงพอ");
                    }

                    $accounts = AccountStock::where('product_id', $product->id)
                        ->where('status', 'available')
                        ->lockForUpdate()
                        ->limit($qty)
                        ->get();

                    if ($accounts->count() < $qty) {
                        throw new \Exception("สินค้า {$product->plan_name} มีจำนวนบัญชีพร้อมส่งมอบไม่เพียงพอ");
                    }

                    $itemsToProcess[] = compact('product', 'qty', 'accounts');
                }

                // 2) คูปอง
                $couponCode = $request->input('coupon_code');
                if (! empty($couponCode)) {
                    $validation = $couponService->validate($couponCode, $user, $cartItems);
                    if (! ($validation['valid'] ?? false)) {
                        throw new \Exception($validation['message'] ?? 'คูปองไม่ถูกต้อง');
                    }
                }

                $applied = $couponService->apply($couponCode, $cartItems);
                $coupon = $applied['coupon'];

                // 3) หักยอดเงิน (ชำระเงินจำลอง)
                $lockedUser = User::whereKey($user->id)->lockForUpdate()->first();
                if ($lockedUser->balance < $applied['total']) {
                    throw new \Exception('ยอดเงินคงเหลือไม่เพียงพอ');
                }
                $lockedUser->decrement('balance', $applied['total']);

                // 4) สร้าง order + order_items
                $order = Order::create([
                    'user_id'         => $user->id,
                    'coupon_id'       => $coupon?->id,
                    'subtotal'        => $applied['subtotal'],
                    'discount_amount' => $applied['discount'],
                    'total'           => $applied['total'],
                    'status'          => 'paid',
                ]);

                // 5) ตัดสต็อก + ผูกบัญชี
                foreach ($itemsToProcess as $p) {
                    $order->products()->attach($p['product']->id, [
                        'quantity'   => $p['qty'],
                        'unit_price' => $p['product']->price,
                    ]);

                    foreach ($p['accounts'] as $account) {
                        $account->update(['order_id' => $order->id, 'status' => 'sold']);
                    }

                    $p['product']->decrement('stock', $p['qty']);
                }

                // 6) บันทึกการใช้คูปอง
                if ($coupon) {
                    $couponService->recordUsage($coupon, $user, $order);
                }

                // 7) ล้างเฉพาะสินค้าที่ซื้อ
                $user->cartProducts()->detach($cartItems->pluck('id')->all());

                return $order;
            });

            return redirect()->route('payment.success', $order);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}