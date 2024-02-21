<?php

use Illuminate\Support\Facades\Route;
use Modules\FileManager\Http\Controllers\FileManagerController;

Route::middleware(['web', 'auth', 'verified', 'active', 'role:administrador|desarrollador'])->prefix('admin')->group(function () {
    Route::get('file-manager', [FileManagerController::class, 'getAll'])->name('file-manager.get');
    Route::post('file-manager', [FileManagerController::class, 'save'])->name('file-manager.save');
});