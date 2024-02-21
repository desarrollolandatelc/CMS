<?php

use Illuminate\Support\Facades\Route;
use Modules\Discounts\Http\Controllers\DiscountController;

Route::prefix('admin')->middleware(['auth', 'web', 'verified', 'role:administrador|desarrollador'])->group(function () {
    Route::delete('/discounts/bulk-delete', [DiscountController::class, 'bulkDestroy'])->name('discounts.bulk-destroy');
    Route::get('discounts/search', [DiscountController::class, 'search'])->name('discounts.search');
    Route::resource('discounts', DiscountController::class);
});
