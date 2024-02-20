<?php

use Illuminate\Support\Facades\Route;
use Modules\Slider\Http\Controllers\SliderController;

Route::prefix('admin')->middleware(['auth', 'web', 'verified', 'role:administrador|desarrollador'])->group(function () {
    Route::delete('/sliders/bulk-delete', [SliderController::class, 'bulkDestroy'])->name('sliders.bulk-destroy');
    Route::get('sliders/search', [SliderController::class, 'search'])->name('sliders.search');
    Route::resource('sliders', SliderController::class);
});
