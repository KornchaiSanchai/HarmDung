<?php

use App\Http\Controllers\Commerce\CartController;
use App\Http\Controllers\Commerce\CheckoutController;
use App\Http\Controllers\Commerce\OrderController;
use App\Http\Controllers\Commerce\PaymentController;
use App\Http\Controllers\Commerce\ProductController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');
Route::view('/home', 'welcome')->name('home');
Route::view('/movie-details', 'movie-details')->name('movie-details');

// Guest ดูสินค้าได้
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/product-info', [ProductController::class, 'show'])->name('product-info');

Route::middleware('auth')->group(function () {
    // ตะกร้า
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'store'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    // ชำระเงิน
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/payment-success/{order}', [PaymentController::class, 'success'])->name('payment.success');

    // ประวัติการสั่งซื้อ
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    // โปรไฟล์
    Route::get('/profile', [MemberController::class, 'info'])->name('profile');
    Route::patch('/profile', [MemberController::class, 'updateProfile'])->name('member.profile.update');
    Route::put('/profile/password', [MemberController::class, 'updatePassword'])->name('member.password.update');
});

require __DIR__.'/settings.php';