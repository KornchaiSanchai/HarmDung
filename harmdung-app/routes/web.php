<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');
Route::view('/home', 'welcome')->name('home');

// หน้าสาธารณะ
Route::view('/products', 'products')->name('products');
Route::view('/product-info', 'product-info')->name('product-info');
Route::view('/movie-details', 'movie-details')->name('movie-details');

// ต้องล็อกอิน
Route::middleware('auth')->group(function () {
    Route::view('/cart', 'cart')->name('cart');
    Route::view('/checkout', 'checkout')->name('checkout');
    Route::view('/payment-success', 'payment-success')->name('payment-success');

    Route::get('/profile', [MemberController::class, 'info'])->name('profile');
    Route::patch('/profile', [MemberController::class, 'updateProfile'])->name('member.profile.update');
    Route::put('/profile/password', [MemberController::class, 'updatePassword'])->name('member.password.update');
});


require __DIR__.'/settings.php';