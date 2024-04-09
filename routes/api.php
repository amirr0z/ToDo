<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\VerificationController;
use App\Http\Middleware\VerifyJsonHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//task routes
Route::middleware(['auth:sanctum', 'verified'])->prefix('tasks')->controller(TaskController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{task}', 'show');
    Route::put('/{task}', 'update');
    Route::delete('/{task}', 'destroy');
});

//auth routes
Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/user', 'user');
        Route::post('/logout', 'logout');
    });
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

//verification routes
Route::prefix('verify')->controller(VerificationController::class)->group(function () {
    Route::get('/{id}/{hash}', 'verify')->middleware(['signed'])->name('verification.verify')->withoutMiddleware([VerifyJsonHeader::class]);
    Route::post('/resend', 'resend')->middleware(['throttle:6,1', 'auth:sanctum'])->name('verification.send');
});
