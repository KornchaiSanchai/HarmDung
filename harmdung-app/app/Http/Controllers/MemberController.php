<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class MemberController extends Controller
{
    public function info(Request $request)
    {
        $user = $request->user();

        $orders = $user->orders()
            ->with(['products.platform', 'coupon', 'accountStocks'])
            ->latest()
            ->get();

        // คำนวณสรุปข้อมูลและผูกบัญชีไอดีหนังทั้งหมดจาก Controller
        $orders->each(function ($order) {
            $order->formatted_date = $order->created_at?->timezone('Asia/Bangkok')->format('d/m/Y H:i');
            $order->status_label = $order->status === 'paid' ? 'ชำระแล้ว' : $order->status;
            $order->formatted_total = number_format($order->total, 2);
            $order->formatted_discount = number_format($order->discount_amount, 2);

            $order->products->each(function ($product) use ($order) {
                $product->order_accounts = $order->accountStocks->where('product_id', $product->id)->values();
                $product->has_accounts = $product->order_accounts->isNotEmpty();
                $product->formatted_unit_price = number_format($product->pivot->unit_price, 2);
                $product->formatted_subtotal = number_format($product->pivot->quantity * $product->pivot->unit_price, 2);
            });
        });

        $formattedBalance = number_format($user->balance, 2);
        $orderCount = $orders->count();
        $recentOrders = $orders->take(2)->values();
        $couponOrders = $orders->whereNotNull('coupon_id')->values();

        return view('profile', [
            'user'             => $user,
            'orders'           => $orders,
            'recentOrders'     => $recentOrders,
            'couponOrders'     => $couponOrders,
            'orderCount'       => $orderCount,
            'formattedBalance' => $formattedBalance,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $request->user()->update($data);

        return redirect()->route('profile', ['tab' => 'settings'])
            ->with('status', 'บันทึกข้อมูลแล้ว');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => [
                'required',
                'confirmed',
                Password::defaults(),
                'different:current_password',
                function ($attribute, $value, $fail) use ($request) {
                    if (\Illuminate\Support\Facades\Hash::check($value, $request->user()->password)) {
                        $fail('รหัสผ่านใหม่ต้องไม่ตรงกับรหัสผ่านเดิม');
                    }
                },
            ],
        ], [
            'current_password.required' => 'กรุณากรอกรหัสผ่านปัจจุบัน',
            'current_password.current_password' => 'รหัสผ่านปัจจุบันไม่ถูกต้อง',
            'password.required' => 'กรุณากรอกรหัสผ่านใหม่',
            'password.confirmed' => 'การยืนยันรหัสผ่านใหม่ไม่ตรงกัน',
            'password.different' => 'รหัสผ่านใหม่ต้องไม่ตรงกับรหัสผ่านเดิม',
        ]);

        // cast 'hashed' ใน User model จะเข้ารหัสให้เอง
        $request->user()->update(['password' => $request->password]);

        return redirect()->route('profile', ['tab' => 'settings'])
            ->with('status', 'เปลี่ยนรหัสผ่านแล้ว');
    }
}