<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\CustomerAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);
});

Route::middleware('auth:customer')->group(function () {
    Route::get('/customer/dashboard', function () {
        return view('customer.dashboard');
    });
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::get('/register', [AdminAuthController::class, 'showRegister']);
    Route::post('/register', [AdminAuthController::class, 'register']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->middleware('auth:admin');
    Route::get('products/import', [ProductController::class, 'show'])->name('products.import.form');
    Route::post('products/import', [ProductController::class, 'import'])->name('admin.products.import');
});

    Route::prefix('customer')->group(function () {
        Route::get('/login', [CustomerAuthController::class, 'showLogin'])->name('customer.login');
        Route::post('/login', [CustomerAuthController::class, 'login']);
        Route::get('/register', [CustomerAuthController::class, 'showRegister']);
        Route::post('/register', [CustomerAuthController::class, 'register']);
        Route::post('/logout', [CustomerAuthController::class, 'logout'])->middleware('auth:customer');
});
