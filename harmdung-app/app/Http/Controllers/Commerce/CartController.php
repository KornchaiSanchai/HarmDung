<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = $request->user()->cartProducts()->with('platform')->get();

        return view('cart', compact('cartItems'));
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
        return back()->with('error', 'สินค้ามีไม่เพียงพอ คงเหลือ '.$available.' ชิ้น');
    }

    $existing = $user->cartProducts()->where('cart_items.product_id', $product->id)->first();

    if ($existing) {
        $user->cartProducts()->updateExistingPivot($product->id, [
            'quantity' => $existing->pivot->quantity + $qty,
        ]);
    } else {
        $user->cartProducts()->attach($product->id, ['quantity' => $qty]);
    }

    return back()->with('success', 'เพิ่มสินค้าลงในตะกร้าเรียบร้อยแล้ว');
}
    public function update(Request $request, $productId)
    {
       $available = \App\Models\AccountStock::where('product_id', $productId)
    ->where('status', 'available')
    ->count();

    $request->validate([
    'quantity' => ['required', 'integer', 'min:1', 'max:'.max($available, 1)],
]);
        return $request->wantsJson()
            ? response()->json(['ok' => true])
            : back()->with('success', 'อัปเดตจำนวนสินค้าเรียบร้อยแล้ว');
    }

    public function destroy(Request $request, $productId)
    {
        $request->user()->cartProducts()->detach($productId);

        return $request->wantsJson()
            ? response()->json(['ok' => true])
            : back()->with('success', 'ลบสินค้าออกจากตะกร้าเรียบร้อยแล้ว');
    }
}