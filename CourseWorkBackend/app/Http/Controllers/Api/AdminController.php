<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Flat;
use App\Models\Chat;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users_count' => User::where('role', '!=', 'admin')->count(),
            'flats_count' => Flat::count(),
            'chats_count' => Chat::count(),
        ];

        return response()->json($stats);
    }

    public function storeFlat(Request $request)
    {
        // Логика создания квартиры
    }

    public function updateFlat(Request $request, Flat $flat)
    {
        // Логика обновления квартиры
    }

    public function deleteFlat(Flat $flat)
    {
        // Логика удаления квартиры
    }

    public function users()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return response()->json($users);
    }

    public function deleteUser(User $user)
    {
        if ($user->role === 'admin') {
            return response()->json(['message' => 'Невозможно удалить администратора'], 403);
        }

        $user->delete();
        return response()->json(['message' => 'Пользователь успешно удален']);
    }

    public function chats()
    {
        $chats = Chat::with('user')->get();
        return response()->json($chats);
    }

    public function showChat(Chat $chat)
    {
        $chat->load(['messages', 'user']);
        return response()->json($chat);
    }

    public function sendMessage(Request $request, Chat $chat)
    {
        // Логика отправки сообщения от админа
    }
}
