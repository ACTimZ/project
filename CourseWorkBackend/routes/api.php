<?php

use App\Http\Controllers\Api\FlatController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AdminController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/flats', [FlatController::class, 'index']);
Route::get('/flats/{flat}', [FlatController::class, 'show']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites/{flat}', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{flat}', [FavoriteController::class, 'destroy']);

    Route::get('/chats', [ChatController::class, 'index']);
    Route::get('/chats/{chat}', [ChatController::class, 'show']);
    Route::post('/chats', [ChatController::class, 'store']);
    Route::post('/chats/{chat}/messages', [ChatController::class, 'sendMessage']);
});

Route::middleware(['auth:sanctum', 'is.admin'])->prefix('admin')->group(function () {
    // Главная страница админки
    Route::get('/', [AdminController::class, 'dashboard']);

    // Управление квартирами
    Route::get('/edit_flat/{flat}', [AdminController::class, 'editFlat']);
    Route::delete('/delete_flat/{flat}', [AdminController::class, 'deleteFlat']);

    // Управление пользователями
    Route::get('/users', [AdminController::class, 'users']);
    Route::delete('/delete_user/{user}', [AdminController::class, 'deleteUser']);

    // Чаты
    Route::get('/chats', [AdminController::class, 'chats']);
});
