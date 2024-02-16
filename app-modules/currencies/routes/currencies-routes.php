<?php

// use Modules\Currencies\Http\Controllers\CurrenciesController;

use Illuminate\Support\Facades\Route;
use Modules\Currencies\Http\Controllers\CurrencyController;

Route::prefix('admin')->middleware(['auth', 'web', 'verified', 'role:administrador|desarrollador'])->group(function () {
    Route::delete('/currencies/bulk-delete', [CurrencyController::class, 'bulkDestroy'])->name('currencies.bulk-destroy');

    Route::resource('currencies', CurrencyController::class);
});
// Route::get('/currencies', [CurrenciesController::class, 'index'])->name('currencies.index');
// Route::get('/currencies/create', [CurrenciesController::class, 'create'])->name('currencies.create');
// Route::post('/currencies', [CurrenciesController::class, 'store'])->name('currencies.store');
// Route::get('/currencies/{currency}', [CurrenciesController::class, 'show'])->name('currencies.show');
// Route::get('/currencies/{currency}/edit', [CurrenciesController::class, 'edit'])->name('currencies.edit');
// Route::put('/currencies/{currency}', [CurrenciesController::class, 'update'])->name('currencies.update');
// Route::delete('/currencies/{currency}', [CurrenciesController::class, 'destroy'])->name('currencies.destroy');
