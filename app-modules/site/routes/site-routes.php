<?php

use Illuminate\Support\Facades\Route;
use Modules\Site\Http\Controllers\SiteController;

Route::prefix('admin')->middleware(['auth', 'web', 'verified', 'role:administrador|desarrollador'])->get('sites/variant', [SiteController::class, 'variant'])->name('sites.variants');
Route::prefix('admin')->middleware(['auth', 'web', 'verified', 'role:desarrollador'])->group(function () {
    Route::delete('/sites/bulk-delete', [SiteController::class, 'bulkDestroy'])->name('sites.bulk-destroy');
    Route::get('sites/search', [SiteController::class, 'search'])->name('sites.search');
    Route::resource('sites', SiteController::class);
});
