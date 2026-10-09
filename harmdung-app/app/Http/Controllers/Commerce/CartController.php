<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 1. แสดงรายการสินค้าในตะกร้า
    public function index()
    {
        $user = auth()->user();
        $cartItems = $user->cartProducts; // ดึงสินค้าในตะกร้าพร้อมข้อมูล pivot (quantity)

        return view('commerce.cart', compact('cartItems'));
    }

    // 2. เพิ่มสินค้าลงตะกร้า
    public function store(Request $request, $productId)
    {
        $user = auth()->user();
        $product = Product::findOrFail($productId);
        $qty = $request->input('quantity', 1);

        // เช็กว่ามีสินค้านี้ในตะกร้าหรือยัง
        $existingItem = $user->cartProducts()->where('product_id', $productId)->first();

        if ($existingItem) {
            // ถ้ามีแล้ว ให้บวกจำนวนเพิ่ม
            $newQty = $existingItem->pivot->quantity + $qty;
            $user->cartProducts()->updateExistingPivot($productId, ['quantity' => $newQty]);
        } else {
            // ถ้ายังไม่มี ให้ attach เข้าไปใหม่
            $user->cartProducts()->attach($productId, ['quantity' => $qty]);
        }

        return redirect()->back()->with('success', 'เพิ่มสินค้าลงในตะกร้าเรียบร้อยแล้ว');
    }

    // 3. ปรับเปลี่ยนจำนวนสินค้า
    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1', // ต้อง > 0 ตาม constraint
        ]);

        auth()->user()->cartProducts()->updateExistingPivot($productId, [
            'quantity' => $request->quantity
        ]);

        return redirect()->back()->with('success', 'อัปเดตจำนวนสินค้าเรียบร้อยแล้ว');
    }

    // 4. ลบสินค้าออกจากตะกร้า
    public function destroy($productId)
    {
        auth()->user()->cartProducts()->detach($productId);

        return redirect()->back()->with('success', 'ลบสินค้าออกจากตะกร้าเรียบร้อยแล้ว');
    }
}