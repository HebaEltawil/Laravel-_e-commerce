<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserProfileController;

Route::get('/', [ProductController::class, 'home'])->name('home');

Route::resource('products',ProductController::class);

Route::middleware(['auth'])->group(function () {
    Route::resource('userProfile',UserProfileController::class);
    Route::get('order/{orderId}',[UserProfileController::class,'show'])->name('orders.show');
});

Route::post('logout', [UserProfileController::class, 'logout'])->name('logout');


Route::get('/contact', function () {
    return view('user_view.shared.contact');
})->name('contact');

Route::get('/about', function () {
    return view('user_view.shared.about');
})->name('about');

Route::get('/blog', function () {
    return view('user_view.shared.blog');
})->name('blog');

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



// Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'AllProducts'])->name('admin.products.index'); // List all products
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create'); // Create product form
    Route::post('/products/store', [AdminController::class, 'storeProduct'])->name('products.store'); // Store product
    Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit'); // Edit product form
    Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('products.update'); // Update product
    Route::delete('/{id}', [AdminController::class, 'destroyProduct'])->name('products.destroy'); // Delete product
    // Route::delete('/admin/products/image/{id}', [AdminController::class, 'deleteImage'])->name('product.image.delete');
});

Route::prefix('admin/categories')->group(function () {
    Route::get('/', [AdminController::class, 'AllCategories'])->name('admin.categories.index');
    Route::get('/create', [AdminController::class, 'createCategory'])->name('categories.create');
    Route::post('/store', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/{id}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
    Route::put('/{id}', [AdminController::class, 'updateCategory'])->name('categories.update'); 
    Route::delete('/{id}', [AdminController::class, 'destroyCategory'])->name('categories.destroy'); 
});

// Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');

Route::prefix('/admin/orders')->group(function () {
    Route::get('/', [AdminController::class, 'AllOrders'])->name('admin.orders.index');
    Route::get('/{orderId}',[AdminController::class,'showOrder'])->name('admin.orders.show');
    Route::delete('/{orderId}', [AdminController::class, 'removeOrder'])->name('admin.orders.remove');
});
require __DIR__.'/auth.php';
