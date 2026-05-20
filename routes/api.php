<?php
// routes/api.php

use App\Http\Controllers\Api\AgendaController;
use Illuminate\Support\Facades\Route;

// Agenda routes
Route::prefix('agenda')->group(function () {
    Route::get('/', [AgendaController::class, 'index']);
    Route::get('/{id}', [AgendaController::class, 'show']);
    Route::post('/', [AgendaController::class, 'store']);
    Route::put('/{id}', [AgendaController::class, 'update']);
    Route::delete('/{id}', [AgendaController::class, 'destroy']);
});
