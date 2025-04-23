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
    Route::get('/', [AdminController::class, 'dashboard']);
    Route::get('/users', [AdminController::class, 'users']);
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser']);

    Route::post('/flats', [FlatController::class, 'store']);
    Route::put('/flats/{flat}', [FlatController::class, 'update']);
    Route::delete('/flats/{flat}', [FlatController::class, 'destroy']);

    Route::get('/chats', [AdminController::class, 'chats']);
});
