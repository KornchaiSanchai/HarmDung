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

        $request->user()->cartProducts()->updateExistingPivot($productId, [
            'quantity' => $qty,
        ]);

        return $request->wantsJson() || $request->ajax()
            ? response()->json(['ok' => true, 'message' => 'อัปเดตจำนวนสินค้าเรียบร้อยแล้ว'])
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