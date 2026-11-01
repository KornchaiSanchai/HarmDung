<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Commerce\ProductController;
use App\Http\Controllers\Commerce\CartController;
use App\Http\Controllers\Commerce\CheckoutController;
use App\Http\Controllers\Commerce\OrderController;

/*
 * วางที่ routes/commerce.php
 * ต้อง require ใน routes/web.php: require __DIR__.'/commerce.php';
 */

// ---------- Public (Guest ดูได้) ----------
Route::get('/platforms/{platform}/products', [ProductController::class, 'byPlatform'])
    ->name('products.byPlatform');

// ---------- Member only (ต้องล็อกอินก่อนเข้าใช้งาน) ----------
Route::middleware('auth')->group(function () {
    // 1. ตะกร้าสินค้า (Cart)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'store'])->name('cart.add');
    Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartController::class, 'destroy'])->name('cart.remove');

    // 2. ชำระเงินจำลอง (Checkout)
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // 3. ประวัติการสั่งซื้อ (Orders)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});