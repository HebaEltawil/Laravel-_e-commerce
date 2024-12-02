<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('user_view.home');
})->name('home');

Route::get('/product', function () {
    return view('user_view.product.product');
})->name('product');

Route::get('/contact', function () {
    return view('user_view.shared.contact');
})->name('contact');

Route::get('/about', function () {
    return view('user_view.shared.about');
})->name('about');

Route::get('/blog', function () {
    return view('user_view.shared.blog');
})->name('blog');

Route::get('/product_details', function () {
    return view('user_view.product.product_details');
})->name('product_details');

Route::get('/shoping_cart', function () {
    return view('user_view.cart.shoping_cart');
})->name('shoping_cart');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
