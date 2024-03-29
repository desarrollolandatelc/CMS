<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Modules\MenuItems\Http\Controllers\MenuItemController;
use Modules\Providers\Http\Controllers\ProviderController;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return Inertia::render('Inicio/Index');
});


Route::prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render(component: 'Dashboard');
    })->name('dashboard');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Obtener todos los roles de usuario
    Route::get('roles/get-all-from-api', function () {
        return Role::all();
    })->name('admin.roles.get-all-from-api');
})->middleware(['auth', 'verified', 'role:administrador|desarrollador']);


Route::get('menu-items/get-all-by-module-alias', [MenuItemController::class, 'getAllByModuleAlias'])->name('menu-items.get-all-by-module-alias');

require __DIR__ . '/auth.php';
