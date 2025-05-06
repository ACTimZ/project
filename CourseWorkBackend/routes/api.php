<?php

use App\Http\Controllers\Api\FlatController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/flats', [FlatController::class, 'index']);
Route::get('/flats/{flat}', [FlatController::class, 'show']);

Route::get('/favourites', [FavoriteController::class, 'index']);
Route::post('/favourites', [FavoriteController::class, 'store']);
Route::delete('/favourites', [FavoriteController::class, 'destroy']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
});

// Маршруты для админа
Route::middleware(['auth:sanctum', 'is.admin'])->prefix('admin')->group(function () {
    // Главная страница админки
    Route::get('/', [AdminController::class, 'dashboard']);

    // Управление квартирами
    Route::post('/flats', [FlatController::class, 'store']);
    Route::put('/flats/{flat}', [FlatController::class, 'update']);
    Route::delete('/flats/{flat}', [FlatController::class, 'destroy']);

    // Управление пользователями
    Route::get('/users', [AdminController::class, 'users']);
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser']);
});
