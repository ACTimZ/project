<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'favorites_count' => $request->user()->favorites()->count(),
            'chats' => $request->user()->chats()->with('messages')->get()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|unique:users,phone,' . $request->user()->id,
            'email' => 'sometimes|required|email|unique:users,email,' . $request->user()->id,
            'password' => 'sometimes|required|min:8|confirmed'
        ]);

        $data = $request->only(['first_name', 'last_name', 'phone', 'email']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $request->user()->update($data);

        return response()->json([
            'message' => 'Профиль успешно обновлен',
            'user' => $request->user()
        ]);
    }
}
