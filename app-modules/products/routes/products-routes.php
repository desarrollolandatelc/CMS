<?php

// use Modules\Products\Http\Controllers\ProductsController;

use Illuminate\Support\Facades\Route;
use Modules\Products\Http\Controllers\ProductController;

Route::prefix('admin')->middleware(['auth', 'web', 'verified', 'role:administrador|desarrollador'])->group(function () {
    Route::delete('/products/bulk-delete', [ProductController::class, 'bulkDestroy'])->name('products.bulk-destroy');

    Route::resource('products', ProductController::class);
});
// Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
// Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
// Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
// Route::get('/products/{product}', [ProductsController::class, 'show'])->name('products.show');
// Route::get('/products/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit');
// Route::put('/products/{product}', [ProductsController::class, 'update'])->name('products.update');
// Route::delete('/products/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');
