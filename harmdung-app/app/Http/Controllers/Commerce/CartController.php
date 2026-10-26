<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $cartItems = $user->cartProducts()->with('platform')->get();

        // คำนวณสรุปราคาและจำนวนสินค้าจาก Backend ทั้งหมด
        $cartItems->each(function ($item) {
            $item->subtotal = $item->price * $item->pivot->quantity;
            $item->formatted_price = number_format($item->price, 2) . ' บาท';
            $item->formatted_subtotal = number_format($item->subtotal, 2) . ' บาท';
            $item->current_stock = $item->available_stock;
        });

        $totalCount = $cartItems->sum(fn ($i) => $i->pivot->quantity);
        $totalAmount = $cartItems->sum(fn ($i) => $i->subtotal);
        $formattedTotal = number_format($totalAmount, 2);

        return view('cart', compact('cartItems', 'totalCount', 'totalAmount', 'formattedTotal'));
    }

    // คำนวณยอดเงินและจำนวนสินค้าตามรายการ checkbox ที่ผู้ใช้เลือก
    public function calculate(Request $request)
    {
        $user = $request->user();
        $selectedIds = array_filter((array) $request->input('items', []));

        if (empty($selectedIds)) {
            return response()->json([
                'count'           => 0,
                'total'           => 0.00,
                'total_formatted' => '0.00',
                'can_checkout'    => false,
            ]);
        }

        $items = $user->cartProducts()
            ->whereIn('products.id', $selectedIds)
            ->get();

        $count = $items->sum(fn ($i) => $i->pivot->quantity);
        $total = $items->sum(fn ($i) => $i->price * $i->pivot->quantity);

        return response()->json([
            'count'           => $count,
            'total'           => $total,
            'total_formatted' => number_format($total, 2),
            'can_checkout'    => $count > 0,
        ]);
    }

    // รับเฉพาะ id สินค้า ไม่เชื่อราคาจากฟอร์ม
    public function store(Request $request, $productId)
    {
        $user = $request->user();
        $product = Product::findOrFail($productId);
        $qty = max(1, (int) $request->input('quantity', 1));

        $available = $product->accountStocks()->where('status', 'available')->count();
        $current   = $user->cartProducts()->where('cart_items.product_id', $product->id)->first()?->pivot->quantity ?? 0;

        if ($available < 1 || $current + $qty > $available) {
            $errorMsg = 'จำนวนสินค้าในตะกร้าเกินจำนวนสินค้าที่มีในสต็อก (คงเหลือ '.$available.' ชิ้น)';
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success'   => false,
                    'message'   => $errorMsg,
                    'available' => $available,
                ], 422);
            }
            return back()->with('error', $errorMsg);
        }

        $existing = $user->cartProducts()->where('cart_items.product_id', $product->id)->first();

        if ($existing) {
            $user->cartProducts()->updateExistingPivot($product->id, [
                'quantity' => $existing->pivot->quantity + $qty,
            ]);
        } else {
            $user->cartProducts()->attach($product->id, ['quantity' => $qty]);
        }

        $successMsg = 'เพิ่มสินค้าลงในตะกร้าเรียบร้อยแล้ว';
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success'    => true,
                'message'    => $successMsg,
                'cart_count' => $user->cartProducts()->count(),
            ]);
        }

        return back()->with('success', $successMsg);
    }

    public function update(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $available = $product->accountStocks()->where('status', 'available')->count();
        $qty = (int) $request->input('quantity', 1);

        if ($qty > $available) {
            $msg = 'จำนวนสินค้าใน stock ไม่เพียงพอ';
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'message'   => $msg,
                    'errors'    => ['quantity' => [$msg]],
                    'available' => $available,
                ], 422);
            }
            return back()->with('error', $msg);
        }

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $user = $request->user();
        $user->cartProducts()->updateExistingPivot($productId, [
            'quantity' => $qty,
        ]);

        // คำนวณยอดเงินและรายการสรุปใหม่จาก Backend
        $itemSubtotal = $product->price * $qty;
        $updatedCartItems = $user->cartProducts()->get();
        $cartTotal = $updatedCartItems->sum(fn ($i) => $i->price * $i->pivot->quantity);
        $cartCount = $updatedCartItems->sum(fn ($i) => $i->pivot->quantity);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'ok'                    => true,
                'message'               => 'อัปเดตจำนวนสินค้าเรียบร้อยแล้ว',
                'product_id'            => $product->id,
                'quantity'              => $qty,
                'available_stock'       => $available,
                'item_subtotal'         => $itemSubtotal,
                'item_subtotal_text'    => number_format($itemSubtotal, 2) . ' บาท',
                'cart_total'            => $cartTotal,
                'cart_total_formatted'  => number_format($cartTotal, 2),
                'cart_count'            => $cartCount,
            ]);
        }

        return back()->with('success', 'อัปเดตจำนวนสินค้าเรียบร้อยแล้ว');
    }

    public function destroy(Request $request, $productId)
    {
        $request->user()->cartProducts()->detach($productId);

        return $request->wantsJson()
            ? response()->json(['ok' => true])
            : back()->with('success', 'ลบสินค้าออกจากตะกร้าเรียบร้อยแล้ว');
    }
}