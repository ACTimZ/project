<?php

// use Illuminate\Http\Request;
use App\Http\Controllers\Api\FlatController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

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

    Route::post('/flats', [AdminController::class, 'storeFlat']);
    Route::put('/flats/{flat}', [AdminController::class, 'updateFlat']);
    Route::delete('/flats/{flat}', [AdminController::class, 'deleteFlat']);

    Route::get('/users', [AdminController::class, 'users']);
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser']);

    Route::get('/chats', [AdminController::class, 'chats']);
    Route::get('/chats/{chat}', [AdminController::class, 'showChat']);
    Route::post('/chats/{chat}/messages', [AdminController::class, 'sendMessage']);
});
