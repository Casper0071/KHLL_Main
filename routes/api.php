<?php

use App\Http\Controllers\Api\AgendaController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Publieke API routes
Route::post('/login', [AuthController::class, 'login']);

Route::prefix('agenda')->group(function () {
    Route::get('/', [AgendaController::class, 'index']);
    Route::get('/{id}', [AgendaController::class, 'show']);
});

// Beschermde API routes (alleen voor ingelogde gebruikers)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Agenda management routes (alleen voor ingelogde gebruikers)
    Route::prefix('agenda')->group(function () {
        Route::post('/', [AgendaController::class, 'store']);
        Route::put('/{id}', [AgendaController::class, 'update']);
        Route::delete('/{id}', [AgendaController::class, 'destroy']);
    });

    // User management routes (alleen voor admins)
    Route::prefix('users')->middleware('admin')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });
});
