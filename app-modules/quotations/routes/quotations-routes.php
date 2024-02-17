<?php

use Illuminate\Support\Facades\Route;
use Modules\Quotations\Http\Controllers\QuotationController;

Route::prefix('admin')->middleware(['auth', 'web', 'verified', 'role:administrador|desarrollador'])->group(function () {
    Route::delete('/quotations/bulk-delete', [QuotationController::class, 'bulkDestroy'])->name('quotations.bulk-destroy');
    Route::resource('quotations', QuotationController::class);
});
