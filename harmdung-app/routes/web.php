<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

// หน้าแรก: ผู้ใช้ที่ออกจากระบบจะถูกส่งมาที่ "/" แล้ว redirect ต่อไป /home
Route::redirect('/', '/home');
Route::view('/home', 'welcome')->name('home');

Route::view('/products', 'products')->name('products');
Route::view('/product-info', 'product-info')->name('product-info');

Route::view('/cart', 'cart')->name('cart');
Route::view('/checkout', 'checkout')->name('checkout');
Route::view('/payment-success', 'payment-success')->name('payment-success');

Route::view('/member', 'member')->name('member');
Route::view('/movie-details', 'movie-details')->name('movie-details');

// หน้าโปรไฟล์ (Member Info page - 1)
Route::get('/profile', [MemberController::class, 'info'])->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
