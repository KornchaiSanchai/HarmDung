<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function info(Request $request)
    {
        // TODO: เปลี่ยนเป็นรายการสั่งซื้อจริงเมื่อมีตาราง orders
        // เช่น $request->user()->orders()->latest()->take(2)->get();
        $recentOrders = collect();

        return view('profile', compact('recentOrders'));
    }
}