<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/home');
Route::view('/home', 'welcome')->name('home');

// guest เข้าได้ เทสด้วยหน้าต่างไม่ระบุตัวตน (incognito)
Route::view('/products', 'products')->name('products');
Route::view('/movie-details', 'movie-details')->name('movie-details');

// ต้องล็อกอิน: guest โดนเด้งไป /login แล้วกลับมาหน้าเดิมหลังล็อกอิน
Route::middleware('auth')->group(function () {
    Route::view('/product-info', 'product-info')->name('product-info');
    Route::view('/cart', 'cart')->name('cart');
    Route::view('/checkout', 'checkout')->name('checkout');
    Route::view('/payment-success', 'payment-success')->name('payment-success');
    Route::redirect('/member', '/profile')->name('member');
    Route::get('/profile', [MemberController::class, 'info'])->name('profile');
    // ทำ controller รีวิวแล้วค่อยเพิ่ม:
    // Route::post('/movies/{id}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::patch('/profile', [MemberController::class, 'updateProfile'])->name('member.profile.update');
    Route::put('/profile/password', [MemberController::class, 'updatePassword'])->name('member.password.update');
});

require __DIR__.'/settings.php';