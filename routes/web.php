<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

Route::prefix('order')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/', [OrderController::class, 'store']);

    Route::get('/{order}/print', [OrderController::class, 'print'])->name('order.print');
    Route::get('/{id}/faktur', [OrderController::class, 'faktur'])->name('orders.faktur');
});

Route::get('/', [HomeController::class, 'index']);
Route::get('product', [ProductController::class, 'index']);
Route::get('category', [CategoryController::class, 'index']);
