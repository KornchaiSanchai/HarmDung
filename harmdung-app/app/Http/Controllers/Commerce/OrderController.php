<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->with('products.platform')
            ->latest()
            ->get();

        return view('orders', compact('orders'));
    }
}