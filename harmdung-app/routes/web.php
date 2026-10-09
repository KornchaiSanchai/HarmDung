<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});



require __DIR__.'/settings.php';
