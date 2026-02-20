<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;

Route::prefix('v1')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('v1.register');
    Route::post('login', [AuthController::class, 'login'])->name('v1.login');
    Route::post('logout', [AuthController::class, 'logout'])->name('v1.logout')->middleware('auth:sanctum');
    Route::get('user', [AuthController::class, 'user'])->name('v1.user')->middleware('auth:sanctum');

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
});
