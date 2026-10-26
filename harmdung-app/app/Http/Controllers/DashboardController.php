<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลจริงจากตารางต่างๆ มาแสดงผลบนการ์ด Dashboard
        $totalProducts = DB::table('products')->count();
        $totalOrders = DB::table('orders')->count();
        $totalUsers = DB::table('users')->count();

        // ส่งตัวแปรไปยังหน้า views/dashboard.blade.php
        return view('dashboard', compact('totalProducts', 'totalOrders', 'totalUsers'));
    }
}