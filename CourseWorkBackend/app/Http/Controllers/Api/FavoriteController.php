<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flat;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Получить все избранные квартиры пользователя
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $favorites = Favorite::with('flat')
            ->where('user_id', $validated['user_id'])
            ->get();

        return response()->json($favorites);
    }
    // public function index(Request $request)
    // {
    //     $favorites = $request->user()->favorites()->with('flat')->get();

    //     return response()->json($favorites);
    // }

    /**
     * Добавить квартиру в избранное
     */
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'flat_id' => 'required|exists:flats,id',
    //     ]);

    //     $user = $request->user();

    //     // Проверка на существование в избранном
    //     $existingFavorite = $user->favorites()
    //         ->where('flat_id', $validated['flat_id'])
    //         ->first();

    //     if ($existingFavorite) {
    //         return response()->json([
    //             'message' => 'Эта квартира уже в избранном'
    //         ], 422);
    //     }

    //     $favorite = $user->favorites()->create([
    //         'flat_id' => $validated['flat_id']
    //     ]);

    //     return response()->json([
    //         'message' => 'Квартира добавлена в избранное',
    //         'favorite' => $favorite
    //     ], 201);
    // }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'flat_id' => 'required|exists:flats,id',
        ]);

        $existingFavorite = Favorite::where('user_id', $validated['user_id'])
            ->where('flat_id', $validated['flat_id'])
            ->first();

        if ($existingFavorite) {
            return response()->json([
                'message' => 'Эта квартира уже в избранном'
            ], 201);
        }

        $favorite = Favorite::create([
            'user_id' => $validated['user_id'],
            'flat_id' => $validated['flat_id'],
        ]);

        return response()->json([
            'message' => 'Квартира добавлена в избранное',
            'favorite' => $favorite
        ], 201);
    }

    /**
     * Удалить квартиру из избранного
     */
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'flat_id' => 'required|exists:flats,id',
        ]);

        Favorite::where('user_id', $validated['user_id'])
            ->where('flat_id', $validated['flat_id'])
            ->delete();

        return response()->json([
            'message' => 'Квартира удалена из избранного'
        ]);
    }
}
