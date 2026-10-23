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

    public function store(Request $request, $productId)
    {
        $user = $request->user();
        $product = Product::findOrFail($productId);
        $qty = max(1, (int) $request->input('quantity', 1));

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
        $request->validate(['quantity' => 'required|integer|min:1']);

        $request->user()->cartProducts()->updateExistingPivot($productId, [
            'quantity' => $request->quantity,
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