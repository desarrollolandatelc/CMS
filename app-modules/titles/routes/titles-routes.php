<?php

// use Modules\Titles\Http\Controllers\TitlesController;

use Illuminate\Support\Facades\Route;
use Modules\Titles\Http\Controllers\TitleController;

Route::prefix('admin')->middleware(['auth', 'web', 'verified', 'role:administrador|desarrollador'])->group(function () {
    Route::delete('/titles/bulk-delete', [TitleController::class, 'bulkDestroy'])->name('titles.bulk-destroy');
    Route::get('titles/search', [TitleController::class, 'search'])->name('titles.search');

    Route::resource('titles', TitleController::class);
});
// Route::get('/titles', [TitlesController::class, 'index'])->name('titles.index');
// Route::get('/titles/create', [TitlesController::class, 'create'])->name('titles.create');
// Route::post('/titles', [TitlesController::class, 'store'])->name('titles.store');
// Route::get('/titles/{title}', [TitlesController::class, 'show'])->name('titles.show');
// Route::get('/titles/{title}/edit', [TitlesController::class, 'edit'])->name('titles.edit');
// Route::put('/titles/{title}', [TitlesController::class, 'update'])->name('titles.update');
// Route::delete('/titles/{title}', [TitlesController::class, 'destroy'])->name('titles.destroy');
