<?php

use Illuminate\Support\Facades\Route;
use Modules\Modules\Http\Controllers\ModuleController;

Route::get('modules/get-all-by-type', [ModuleController::class, 'getAllByType'])->name('modules.get-all-by-type')->prefix('admin')->middleware(['auth', 'web', 'verified', 'role:administrador|desarrollador']);
Route::prefix('admin')->middleware(['auth', 'web', 'verified', 'role:desarrollador'])->group(function () {
    Route::delete('/modules/bulk-delete', [ModuleController::class, 'bulkDestroy'])->name('modules.bulk-destroy');
    Route::get('modules/search', [ModuleController::class, 'search'])->name('modules.search');
    Route::resource('modules', ModuleController::class);
});
