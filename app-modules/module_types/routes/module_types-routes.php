<?php

use Illuminate\Support\Facades\Route;
use Modules\ModuleTypes\Http\Controllers\ModuleTypeController;

Route::prefix('admin')->middleware(['auth', 'web', 'verified', 'role:desarrollador'])->group(function () {
    Route::delete('/module-types/bulk-delete', [ModuleTypeController::class, 'bulkDestroy'])->name('module-types.bulk-destroy');
    Route::get('module-types/search', [ModuleTypeController::class, 'search'])->name('module-types.search');
    Route::resource('module-types', ModuleTypeController::class);
});
