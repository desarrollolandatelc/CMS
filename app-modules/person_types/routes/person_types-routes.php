<?php

// use Modules\PersonTypes\Http\Controllers\PersonTypesController;

use Illuminate\Support\Facades\Route;
use Modules\PersonTypes\Models\PersonType;

Route::prefix('admin')->middleware(['auth', 'web', 'verified', 'role:administrador|desarrollador'])->group(function () {
    Route::get('person-types/get-all-from-api', function () {
        return response()->json(PersonType::with('documentTypes')->get());
    })->name('person-types.get-all-from-api');
});
// Route::get('/person_types', [PersonTypesController::class, 'index'])->name('person_types.index');
// Route::get('/person_types/create', [PersonTypesController::class, 'create'])->name('person_types.create');
// Route::post('/person_types', [PersonTypesController::class, 'store'])->name('person_types.store');
// Route::get('/person_types/{person_type}', [PersonTypesController::class, 'show'])->name('person_types.show');
// Route::get('/person_types/{person_type}/edit', [PersonTypesController::class, 'edit'])->name('person_types.edit');
// Route::put('/person_types/{person_type}', [PersonTypesController::class, 'update'])->name('person_types.update');
// Route::delete('/person_types/{person_type}', [PersonTypesController::class, 'destroy'])->name('person_types.destroy');
