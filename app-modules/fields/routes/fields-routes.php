<?php

// use Modules\Fields\Http\Controllers\FieldsController;

use Illuminate\Support\Facades\Route;
use Modules\Fields\Http\Controllers\FieldController;

Route::prefix('admin')->middleware(['auth', 'web', 'verified', 'role:administrador|desarrollador'])->group(function () {
    Route::delete('/fields/bulk-delete', [FieldController::class, 'bulkDestroy'])->name('fields.bulk-destroy');
    Route::get('fields/search', [FieldController::class, 'search'])->name('fields.search');
    Route::resource('fields', FieldController::class);
});
// Route::get('/fields', [FieldsController::class, 'index'])->name('fields.index');
// Route::get('/fields/create', [FieldsController::class, 'create'])->name('fields.create');
// Route::post('/fields', [FieldsController::class, 'store'])->name('fields.store');
// Route::get('/fields/{field}', [FieldsController::class, 'show'])->name('fields.show');
// Route::get('/fields/{field}/edit', [FieldsController::class, 'edit'])->name('fields.edit');
// Route::put('/fields/{field}', [FieldsController::class, 'update'])->name('fields.update');
// Route::delete('/fields/{field}', [FieldsController::class, 'destroy'])->name('fields.destroy');
