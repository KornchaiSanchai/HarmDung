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
            ->with(['products.platform', 'coupon'])
            ->latest()
            ->get();

        return view('profile', [
            'user'         => $user,
            'orders'       => $orders,
            'recentOrders' => $orders->take(2),
            'couponOrders' => $orders->whereNotNull('coupon_id'),
            'orderCount'   => $orders->count(),
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
            'password'         => ['required', 'confirmed', Password::defaults()],
        ]);

        // cast 'hashed' ใน User model จะเข้ารหัสให้เอง
        $request->user()->update(['password' => $request->password]);

        return redirect()->route('profile', ['tab' => 'settings'])
            ->with('status', 'เปลี่ยนรหัสผ่านแล้ว');
    }
}