<?php

// use Modules\Categories\Http\Controllers\CategoriesController;

use Illuminate\Support\Facades\Route;
use Modules\Categories\Http\Controllers\CategoryController;

Route::prefix('admin')->middleware(['auth', 'web', 'verified', 'role:administrador|desarrollador'])->group(function () {
    Route::delete('/categories/bulk-delete', [CategoryController::class, 'bulkDestroy'])->name('categories.bulk-destroy');
    Route::get('categories/search', [CategoryController::class, 'search'])->name('categories.search');

    Route::resource('categories', CategoryController::class);
});
// Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
// Route::get('/categories/create', [CategoriesController::class, 'create'])->name('categories.create');
// Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');
// Route::get('/categories/{category}', [CategoriesController::class, 'show'])->name('categories.show');
// Route::get('/categories/{category}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
// Route::put('/categories/{category}', [CategoriesController::class, 'update'])->name('categories.update');
// Route::delete('/categories/{category}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
