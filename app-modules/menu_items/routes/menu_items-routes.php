<?php

use Illuminate\Support\Facades\Route;
use Modules\MenuItems\Http\Controllers\MenuItemController;

Route::prefix('admin')->middleware(['auth', 'web', 'verified', 'role:administrador|desarrollador'])->group(function () {
    Route::delete('/menu-items/bulk-delete', [MenuItemController::class, 'bulkDestroy'])->name('menu-items.bulk-destroy');
    Route::get('menu-items/search', [MenuItemController::class, 'search'])->name('menu-items.search');
    Route::get('modules/get-all-by-module-id', [MenuItemController::class, 'getAllByModuleId'])->name('modules.get-all-by-module-id');

    Route::resource('menu-items', MenuItemController::class);
});
