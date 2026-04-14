<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/search', [DashboardController::class, 'search']);
    Route::patch('/{id}/status', [DashboardController::class, 'updateStatus']);
    Route::delete('/{id}', [DashboardController::class, 'destroy']);
});