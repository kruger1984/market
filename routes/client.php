<?php

declare(strict_types=1);

use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\ProductController;
use Illuminate\Support\Facades\Route;

Route::name('client.')->middleware('auth')->group(function () {
    // Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/{category}/products', [CategoryController::class, 'productIndex'])->name('categories.products.index');

    Route::resource('/carts', CartController::class)->except(['create', 'show', 'edit']);

    //    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    //    Route::get('/orders/{order}/transactions/create', [OrderController::class, 'createTransaction'])->name('orders.transactions.create');
    //    Route::post('/orders/{order}/transactions', [OrderController::class, 'storeTransaction'])->name('orders.transactions.store');

});

// Route::post('transactions/callbacks', [TransactionController::class, 'callback']);
