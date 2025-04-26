<?php

use App\Http\Controllers\Api\FlatController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

// Публичные маршруты
Route::get('/flats', [FlatController::class, 'index']);
Route::get('/flats/{flat}', [FlatController::class, 'show']);

// Маршруты для авторизованных пользователей
Route::middleware('auth:sanctum')->group(function () {

    // Профиль
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    // Избранное
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites/{flat}', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{flat}', [FavoriteController::class, 'destroy']);

    // Чаты для обычных пользователей
    Route::get('/chats', [ChatController::class, 'index']);
    Route::get('/chats/{chat}', [ChatController::class, 'show']);
    Route::post('/chats', [ChatController::class, 'store']);
    Route::post('/chats/{chat}/messages', [ChatController::class, 'sendMessage']);
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

    // Чаты для админа
    Route::get('/chats', [AdminController::class, 'chats']);
});
