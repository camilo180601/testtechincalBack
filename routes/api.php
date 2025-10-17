<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;

Route::middleware(['auth.api'])->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);

    Route::post('/orders', [OrderController::class, 'store'])->middleware('role:operator|admin');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->middleware('role:operator|admin');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->middleware('role:operator|admin');
});

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/refresh', [AuthController::class, 'refresh'])->middleware('auth:api'); // optional, requires valid token
