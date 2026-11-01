<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use App\Models\Order;

class PaymentController extends Controller
{
    public function success(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load(['products.platform']);
        $order->formatted_order_no = '#HD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
        $order->formatted_total = number_format($order->total, 2);
        $order->formatted_discount = number_format($order->discount_amount, 2);
        $order->items_count = $order->products->sum(fn ($product) => $product->pivot->quantity);

        return view('payment-success', compact('order'));
    }
}