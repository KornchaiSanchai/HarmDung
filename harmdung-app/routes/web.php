<?php

use App\Http\Controllers\Commerce\CartController;
use App\Http\Controllers\Commerce\CheckoutController;
use App\Http\Controllers\Commerce\PaymentController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Commerce\ProductController;
use App\Http\Controllers\Commerce\OrderController;
use Illuminate\Support\Facades\Route;

// หน้าแรก: ผู้ใช้ที่ออกจากระบบจะถูกส่งมาที่ "/" แล้ว redirect ต่อไป /home
Route::redirect('/', '/home');
Route::view('/home', 'welcome')->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/product-info', [ProductController::class, 'show'])->name('product-info');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::view('/product-info', 'product-info')->name('product-info');
Route::view('/movie-details', 'movie-details')->name('movie-details');

// กลุ่ม Route สำหรับผู้ใช้ที่เข้าสู่ระบบแล้ว (Auth Middleware)
Route::middleware(['auth'])->group(function () {
    // หน้าโปรไฟล์ (แทนที่ /member เดิม)
    Route::get('/profile', [MemberController::class, 'info'])->name('profile');
    Route::patch('/profile', [MemberController::class, 'update'])->name('member.profile.update');
    Route::put('/profile/password', [MemberController::class, 'updatePassword'])->name('member.password.update');

    
    // จัดการตะกร้าสินค้า (Cart)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'store'])->name('cart.add');
    Route::put('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartController::class, 'destroy'])->name('cart.destroy');

    // ขั้นตอนการชำระเงิน (Checkout)
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    
    // ชำระเงินสำเร็จ
    Route::get('/payment-success/{order}', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';