<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        return 'Admin Dashboard';
    });
});

Route::middleware('auth:customer')->group(function () {
    Route::get('/customer/dashboard', function () {
        return 'Customer Dashboard';
    });
});
