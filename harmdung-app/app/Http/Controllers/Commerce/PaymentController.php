<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use App\Models\Order;

class PaymentController extends Controller
{
    public function success(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        return view('payment-success', compact('order'));
    }
}