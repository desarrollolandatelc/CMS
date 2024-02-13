<?php

use Illuminate\Support\Facades\Route;
use Modules\Clients\Http\Controllers\ClientController;

// Route::get('/clients', [ClientsController::class, 'index'])->name('clients.index');
// Route::get('/clients/create', [ClientsController::class, 'create'])->name('clients.create');


Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
// Route::get('/clients/{client}', [ClientsController::class, 'show'])->name('clients.show');
// Route::get('/clients/{client}/edit', [ClientsController::class, 'edit'])->name('clients.edit');
// Route::put('/clients/{client}', [ClientsController::class, 'update'])->name('clients.update');
// Route::delete('/clients/{client}', [ClientsController::class, 'destroy'])->name('clients.destroy');
