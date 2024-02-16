<?php

// use Modules\Brands\Http\Controllers\BrandsController;

use Illuminate\Support\Facades\Route;
use Modules\Brands\Http\Controllers\BrandController;

Route::prefix('admin')->middleware(['auth', 'web', 'verified', 'role:administrador|desarrollador'])->group(function () {
    Route::delete('/brands/bulk-delete', [BrandController::class, 'bulkDestroy'])->name('brands.bulk-destroy');

    Route::resource('brands', BrandController::class);
});
// Route::get('/brands', [BrandsController::class, 'index'])->name('brands.index');
// Route::get('/brands/create', [BrandsController::class, 'create'])->name('brands.create');
// Route::post('/brands', [BrandsController::class, 'store'])->name('brands.store');
// Route::get('/brands/{brand}', [BrandsController::class, 'show'])->name('brands.show');
// Route::get('/brands/{brand}/edit', [BrandsController::class, 'edit'])->name('brands.edit');
// Route::put('/brands/{brand}', [BrandsController::class, 'update'])->name('brands.update');
// Route::delete('/brands/{brand}', [BrandsController::class, 'destroy'])->name('brands.destroy');
