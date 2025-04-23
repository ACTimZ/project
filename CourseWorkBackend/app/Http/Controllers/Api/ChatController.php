<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $chats = $request->user()
            ->chats()
            ->with(['messages' => function($query) {
                $query->latest()->first();
            }])
            ->latest()
            ->get();

        return response()->json($chats);
    }

    public function show(Chat $chat, Request $request)
    {
        // Проверяем права доступа к чату
        if ($chat->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Доступ запрещен'], 403);
        }

        $chat->load(['messages' => function($query) {
            $query->latest()->with('user');
        }]);

        return response()->json($chat);
    }

    public function store(Request $request)
    {
        $request->validate([
            'flat_id' => 'required|exists:flats,id',
            'message' => 'required|string|max:1000'
        ]);

        // Находим админа для чата
        $admin = User::where('role', 'admin')->first();

        DB::beginTransaction();
        try {
            // Создаем чат или получаем существующий
            $chat = Chat::firstOrCreate([
                'user_id' => $request->user()->id,
                'flat_id' => $request->flat_id
            ]);

            // Создаем сообщение
            $message = $chat->messages()->create([
                'user_id' => $request->user()->id,
                'content' => $request->message
            ]);

            DB::commit();

            return response()->json([
                'chat' => $chat->load('messages'),
                'message' => 'Сообщение отправлено'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ошибка создания чата'], 500);
        }
    }

    public function sendMessage(Request $request, Chat $chat)
    {
        if ($chat->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Доступ запрещен'], 403);
        }

        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $message = $chat->messages()->create([
            'user_id' => $request->user()->id,
            'content' => $request->message
        ]);

        return response()->json($message);
    }
}
