<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appeal;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'phone'      => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'type'       => 'required|in:вопрос,отзыв,квартира',
            'message'    => 'required|string',
        ]);

        $appeal = Appeal::create($data);

        return response()->json(['message' => 'Обращение успешно отправлено'], 201);
    }

    public function index()
    {
        $appeals = Appeal::orderBy('created_at', 'desc')->get([
            'id',
            'first_name',
            'last_name',
            'email',
            'phone',
            'type',
            'message',
            'created_at'
        ]);

        return response()->json($appeals);
    }
}
