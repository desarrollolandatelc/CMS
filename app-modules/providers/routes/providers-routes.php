<?php

use Illuminate\Support\Facades\Route;
use Modules\Providers\Http\Controllers\ProviderController;

Route::prefix('admin')->middleware(['auth', 'verified', 'role:administrator|desarrollador'])->group(function () {
    Route::resource('providers', ProviderController::class);
});

// Route::get('/providers', [ProvidersController::class, 'index'])->name('providers.index');
// Route::get('/providers/create', [ProvidersController::class, 'create'])->name('providers.create');
// Route::post('/providers', [ProvidersController::class, 'store'])->name('providers.store');
// Route::get('/providers/{provider}', [ProvidersController::class, 'show'])->name('providers.show');
// Route::get('/providers/{provider}/edit', [ProvidersController::class, 'edit'])->name('providers.edit');
// Route::put('/providers/{provider}', [ProvidersController::class, 'update'])->name('providers.update');
// Route::delete('/providers/{provider}', [ProvidersController::class, 'destroy'])->name('providers.destroy');
