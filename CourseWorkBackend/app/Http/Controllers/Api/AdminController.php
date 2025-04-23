<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Flat;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Главная страница админ-панели
     */
    public function dashboard()
    {
        $stats = [
            'users_count' => User::where('role', 'user')->count(),
            'flats_count' => Flat::count(),
            'active_chats' => Chat::count(),
            'recent_users' => User::where('role', 'user')
                ->latest()
                ->take(5)
                ->get(),
            'recent_flats' => Flat::latest()
                ->take(5)
                ->get(),
        ];

        return response()->json($stats);
    }

    /**
     * Получение данных для редактирования квартиры
     */
    public function editFlat(Flat $flat)
    {
        return response()->json($flat);
    }

    /**
     * Удаление квартиры
     */
    public function deleteFlat(Flat $flat)
    {
        // Удаляем изображения
        foreach ($flat->images as $image) {
            Storage::disk('public')->delete($image);
        }

        $flat->delete();
        return response()->json(['message' => 'Квартира успешно удалена']);
    }

    /**
     * Список всех пользователей (кроме админов)
     */
    public function users()
    {
        $users = User::where('role', 'user')
            ->withCount(['favorites', 'chats'])
            ->latest()
            ->get();

        return response()->json($users);
    }

    /**
     * Удаление пользователя
     */
    public function deleteUser(User $user)
    {
        if ($user->role === 'admin') {
            return response()->json([
                'message' => 'Нельзя удалить администратора'
            ], 403);
        }

        // Удаляем связанные данные (избранное и чаты удалятся автоматически благодаря внешним ключам)
        $user->delete();

        return response()->json([
            'message' => 'Пользователь успешно удален'
        ]);
    }

    /**
     * Список всех чатов с пользователями
     */
    public function chats()
    {
        $chats = Chat::with(['user', 'flat', 'messages' => function($query) {
            $query->latest()->first();
        }])
        ->latest()
        ->get();

        return response()->json($chats);
    }
}
