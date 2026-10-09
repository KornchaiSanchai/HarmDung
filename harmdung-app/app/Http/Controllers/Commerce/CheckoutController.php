<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use App\Models\AccountStock;
use App\Models\Order;
use App\Models\Product;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // 1. หน้าสรุปรายการก่อนสั่งซื้อ
    public function index(Request $request)
    {
        $user = auth()->user();
        $cartItems = $user->cartProducts;

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'ไม่มีสินค้าในตะกร้า');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->pivot->quantity;
        });

        // ค่าเริ่มต้นสำหรับ view (แจ้งหมวย: ตัวแปรเพิ่มคือ
        // $discountAmount, $total, $couponCode, $couponError)
        $discountAmount = 0;
        $total = $subtotal;
        $couponCode = $request->input('coupon_code');
        $couponError = null;

        if ($request->filled('coupon_code')) {
            // ==========================================================
            // [เรียกใช้ของกร] CouponService::validate($code, $user, $cartItems)
            // - ตรวจเงื่อนไข: โค้ดมีจริง, ไม่หมดอายุ, ยังไม่ใช้ครบจำนวนครั้ง,
            //   ผูกกับสินค้าในตะกร้า
            // - คืนค่าถูกต้อง หรือข้อความผิดพลาด
            //   (TODO: เช็ก format ที่คืนจริงกับกร)
            // ==========================================================
            $check = CouponService::validate($couponCode, $user, $cartItems);

            if ($check !== true) {
                $couponError = is_string($check) ? $check : 'คูปองไม่ถูกต้อง';
            } else {
                // ======================================================
                // [เรียกใช้ของกร] CouponService::apply($code, $cartItems)
                // - คืนยอดลดและยอดรวม เพื่อโชว์ก่อนกดยืนยัน
                // - TODO: ยืนยันกับกรว่า key คือ 'discount_amount'
                // ======================================================
                $couponResult = CouponService::apply($couponCode, $cartItems);
                $discountAmount = $couponResult['discount_amount'] ?? 0;
                $total = max(0, $subtotal - $discountAmount);
            }
        }

        return view('commerce.checkout', compact(
            'cartItems',
            'subtotal',
            'discountAmount',
            'total',
            'couponCode',
            'couponError'
        ));
    }

    // 2. ประมวลผลการสั่งซื้อ (DB Transaction + จัดการ account_stocks + ตัดสต็อก)
    public function store(Request $request)
    {
        $user = auth()->user();
        $cartItems = $user->cartProducts;

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'ไม่มีสินค้าในตะกร้า');
        }

        try {
            DB::transaction(function () use ($user, $cartItems, $request) {
                $subtotal = 0;
                $itemsToProcess = [];

                // 1. เช็กและดึง account_stocks ที่พร้อมใช้งานพร้อมล็อกแถวด้วย lockForUpdate()
                foreach ($cartItems as $item) {
                    $product = Product::where('id', $item->id)->lockForUpdate()->first();
                    $qtyNeeded = $item->pivot->quantity;

                    // ดึงรายการ account_stocks ที่ยังว่าง (status = available) ตามจำนวนที่สั่ง
                    $availableAccounts = AccountStock::where('product_id', $product->id)
                        ->where('status', 'available')
                        ->lockForUpdate()
                        ->limit($qtyNeeded)
                        ->get();

                    // เช็กว่าจำนวนบัญชีในระบบมีพอตามจำนวนที่ต้องการซื้อหรือไม่
                    if ($availableAccounts->count() < $qtyNeeded) {
                        throw new \Exception("สินค้า {$product->plan_name} มีจำนวนบัญชีพร้อมส่งมอบไม่เพียงพอ");
                    }

                    $subtotal += $product->price * $qtyNeeded;

                    $itemsToProcess[] = [
                        'product' => $product,
                        'quantity' => $qtyNeeded,
                        'accounts' => $availableAccounts,
                    ];
                }

                // 2. คำนวณส่วนลดคูปอง (ถ้ามี)
                $discountAmount = 0;
                $coupon = null;

                if ($request->filled('coupon_code')) {
                    // ==========================================================
                    // [เรียกใช้ของกร] CouponService::validate($code, $user, $cartItems)
                    // - ตรวจซ้ำใน transaction เพราะระหว่างอยู่หน้า Checkout
                    //   คูปองอาจหมดอายุหรือถูกคนอื่นใช้ครบไปแล้ว
                    // - คืนค่าถูกต้อง หรือข้อความผิดพลาด
                    //   (TODO: เช็ก format ที่คืนจริงกับกร)
                    // ==========================================================
                    $check = CouponService::validate($request->coupon_code, $user, $cartItems);

                    if ($check !== true) {
                        // throw ใน transaction = rollback ทั้งหมด
                        throw new \Exception(is_string($check) ? $check : 'คูปองไม่ถูกต้อง');
                    }

                    // ==========================================================
                    // [เรียกใช้ของกร] CouponService::apply($code, $cartItems)
                    // - คืนยอดลดและยอดรวม
                    // - TODO: ยืนยันกับกรว่า key คือ 'discount_amount' และ 'coupon'
                    //   (ถ้าชื่อไม่ตรง ส่วนลดจะเป็น 0 เงียบๆ)
                    // ==========================================================
                    $couponResult = CouponService::apply($request->coupon_code, $cartItems);
                    $discountAmount = $couponResult['discount_amount'] ?? 0;
                    $coupon = $couponResult['coupon'] ?? null;
                }

                $total = max(0, $subtotal - $discountAmount);

                // 3. สร้าง Order
                $order = Order::create([
                    'user_id' => $user->id,
                    'coupon_id' => $coupon ? $coupon->id : null,
                    'subtotal' => $subtotal,
                    'discount_amount' => $discountAmount,
                    'total' => $total,
                    'status' => 'paid',
                ]);

                // 4. บันทึกสินค้าใน Order, ตัดสต็อก และอัปเดตสถานะ account_stocks
                foreach ($itemsToProcess as $processed) {
                    $product = $processed['product'];
                    $qty = $processed['quantity'];
                    $accounts = $processed['accounts'];

                    // บันทึก Order Item Snapshot
                    $order->products()->attach($product->id, [
                        'quantity' => $qty,
                        'unit_price' => $product->price,
                    ]);

                    // ผูกบัญชีเข้ากับ order_id และอัปเดตสถานะเป็น sold
                    foreach ($accounts as $account) {
                        $account->update([
                            'order_id' => $order->id,
                            'status' => 'sold',
                        ]);
                    }

                    // ลดจำนวนสต็อกรวมในตาราง products
                    $product->decrement('stock', $qty);
                }

                // 5. บันทึกประวัติการใช้คูปอง
                if ($coupon) {
                    // ==========================================================
                    // [เรียกใช้ของกร] CouponService::recordUsage($coupon, $user, $order)
                    // - บันทึกลง coupon_usages และเพิ่ม used_count
                    // - ต้องเรียก "หลังสร้าง order" (ต้องใช้ $order) และ
                    //   "ใน transaction นี้" เพื่อให้ rollback พร้อมกันถ้าพัง
                    // - ถ้าคูปองถูกใช้ครบระหว่างนี้ กรควร throw เพื่อ rollback
                    // ==========================================================
                    CouponService::recordUsage($coupon, $user, $order);
                }

                // 6. ล้างตะกร้าสินค้าของผู้ใช้
                $user->cartProducts()->detach();
            });

            return redirect()->route('orders.index')->with('success', 'สั่งซื้อสำเร็จเรียบร้อยแล้ว');

        } catch (\Exception $e) {
            // withInput() เพื่อให้โค้ดคูปองที่กรอกไว้ยังอยู่ในช่องหลังเกิด error
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}