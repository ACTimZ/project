<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $chats = $request->user()->chats()
            ->with(['messages' => function($query) {
                $query->latest()->limit(1);
            }])
            ->get();

        return response()->json($chats);
    }

    public function show(Chat $chat, Request $request)
    {
        // Проверяем, принадлежит ли чат текущему пользователю
        if ($chat->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Доступ запрещен'
            ], 403);
        }

        $chat->load(['messages' => function($query) {
            $query->latest()->limit(50);
        }]);

        return response()->json($chat);
    }

    public function store(Request $request)
    {
        $request->validate([
            'flat_id' => 'required|exists:flats,id',
            'message' => 'required|string'
        ]);

        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return response()->json([
                'message' => 'Администратор недоступен'
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Создаем новый чат или получаем существующий
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

            // Здесь можно добавить событие для веб-сокетов
            // event(new NewMessage($message));

            return response()->json([
                'chat' => $chat->load('messages'),
                'message' => 'Сообщение отправлено'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Ошибка при создании чата'
            ], 500);
        }
    }

    public function sendMessage(Request $request, Chat $chat)
    {
        if ($chat->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Доступ запрещен'
            ], 403);
        }

        $request->validate([
            'message' => 'required|string'
        ]);

        $message = $chat->messages()->create([
            'user_id' => $request->user()->id,
            'content' => $request->message
        ]);

        // Здесь можно добавить событие для веб-сокетов
        // event(new NewMessage($message));

        return response()->json([
            'message' => $message,
            'status' => 'Сообщение отправлено'
        ]);
    }
}
