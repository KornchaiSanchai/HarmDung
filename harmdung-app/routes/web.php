<?php

use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// guest เข้าได้ เทสด้วยหน้าต่างไม่ระบุตัวตน (incognito)
Route::view('/products', 'products')->name('products');
Route::view('/product-info', 'product-info')->name('product-info');

Route::view('/cart', 'cart')->name('cart');

// จัดการหน้าชำระเงินและคูปองผ่าน CouponController & CouponService ฝั่ง Backend
Route::get('/checkout', [CouponController::class, 'checkout'])->name('checkout');
Route::post('/coupon/apply', [CouponController::class, 'select'])->name('coupon.apply');
Route::post('/coupon/remove', [CouponController::class, 'remove'])->name('coupon.remove');
Route::get('/coupon/options', [CouponController::class, 'options'])->name('coupon.options');

Route::view('/payment-success', 'payment-success')->name('payment-success');

Route::view('/member', 'member')->name('member');
Route::get('/movie-details', [MovieController::class, 'show'])->name('movie-details');

// ต้องล็อกอิน: guest โดนเด้งไป /login แล้วกลับมาหน้าเดิมหลังล็อกอิน
Route::middleware('auth')->group(function () {
    Route::view('/product-info', 'product-info')->name('product-info');
    Route::view('/cart', 'cart')->name('cart');
    Route::view('/checkout', 'checkout')->name('checkout');
    Route::view('/payment-success', 'payment-success')->name('payment-success');
    Route::redirect('/member', '/profile')->name('member');
    Route::get('/profile', [MemberController::class, 'info'])->name('profile');
    Route::post('/movies/{movie}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::patch('/profile', [MemberController::class, 'updateProfile'])->name('member.profile.update');
    Route::put('/profile/password', [MemberController::class, 'updatePassword'])->name('member.password.update');
});

require __DIR__.'/settings.php';