<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('guest')->group(function () {


    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('admin.login.store');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

Route::prefix('admin')->middleware(['auth', 'verified', 'role:administrador|desarrollador'])->group(function () {
    Route::get('users', [UserController::class, 'index'])
        ->name('users.index');

    Route::get('users/search', [UserController::class, 'search'])
        ->name('users.search');

    Route::delete('user/{user}', [UserController::class, 'destroy'])
        ->name('users.destroy');

    Route::delete('users/bulk-delete', [UserController::class, 'bulkDestroy'])
        ->name('users.bulk-delete');

    Route::get('user/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::get('users/{user}/edit', [RegisteredUserController::class, 'edit'])
        ->name('users.edit');

    Route::put('users/{user}/update', [RegisteredUserController::class, 'update'])
        ->name('users.update');

    Route::post('user/register', [RegisteredUserController::class, 'store'])->name('register.store');
});
