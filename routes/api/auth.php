<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Authentication routes
Route::middleware('throttle:auth')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

// Authenticated routes
Route::middleware('auth:sanctum', 'throttle:authenticated')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('user', [AuthController::class, 'user'])->name('user');
});


// Email verification
Route::post('email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware('auth:sanctum', 'signed')
    ->name('verification.verify');
Route::post('email/send-verification', [AuthController::class, 'sendVerificationEmail'])
    ->middleware('auth:sanctum', 'throttle:6,1')
    ->name('verification.send');


// Password reset
Route::post('forgot-password', [AuthController::class, 'forgotPassword'])
    ->middleware('throttle:6,1')
    ->name('password.forgot');
Route::post('reset-password', [AuthController::class, 'resetPassword'])
    ->middleware('throttle:6,1')
    ->name('password.reset');
