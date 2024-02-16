<?php

use Illuminate\Support\Facades\Route;
use Modules\Articles\Http\Controllers\ArticleController;

Route::prefix('admin')->middleware(['auth', 'web', 'verified', 'role:administrador|desarrollador'])->group(function () {
    Route::delete('/articles/bulk-delete', [ArticleController::class, 'bulkDestroy'])->name('articles.bulk-destroy');
    Route::resource('articles', ArticleController::class);
});
