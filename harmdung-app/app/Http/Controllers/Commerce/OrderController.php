<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function index()
    {
        $orders = auth()->user()->orders()->with('products')->latest()->get();

        return view('commerce.orders', compact('orders'));
    }
}