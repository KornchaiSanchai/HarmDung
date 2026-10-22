<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

// หน้าแรก: ผู้ใช้ที่ออกจากระบบจะถูกส่งมาที่ "/" แล้ว redirect ต่อไป /home
Route::redirect('/', '/home');
Route::view('/home', 'welcome')->name('home');

Route::get('/products', function () {
    return view('products');
});

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/checkout', function () {
    return view('checkout');
});

// หน้าโปรไฟล์ (Member Info page - 1)
// ชั่วคราว: เข้าได้โดยไม่ต้องล็อกอิน (ยังไม่ได้ทำระบบ login)
// TODO: เมื่อทำ login แล้ว ให้ครอบด้วย Route::middleware('auth')->group(...)
Route::get('/profile', [MemberController::class, 'info'])->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';