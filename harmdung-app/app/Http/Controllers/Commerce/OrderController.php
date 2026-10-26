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
            ->with(['products.platform', 'accountStocks'])
            ->latest()
            ->get();

        // คำนวณยอดเงิน จัดรูปแบบ และผูกบัญชีไอดีหนังทั้งหมดจาก Controller
        $orders->each(function ($order) {
            $order->formatted_date = $order->created_at->format('d/m/Y H:i');
            $order->status_label = $order->status === 'paid' ? 'ชำระแล้ว' : $order->status;
            $order->formatted_total = number_format($order->total, 2);
            $order->formatted_discount = number_format($order->discount_amount, 2);

            $order->products->each(function ($product) use ($order) {
                $subtotal = $product->pivot->quantity * $product->pivot->unit_price;
                $product->calculated_subtotal = $subtotal;
                $product->formatted_subtotal = number_format($subtotal, 2);
                $product->formatted_unit_price = number_format($product->pivot->unit_price, 2);
                $product->order_accounts = $order->accountStocks->where('product_id', $product->id)->values();
                $product->has_accounts = $product->order_accounts->isNotEmpty();
            });
        });

        $orderCount = $orders->count();

        return view('orders', compact('orders', 'orderCount'));
    }
}