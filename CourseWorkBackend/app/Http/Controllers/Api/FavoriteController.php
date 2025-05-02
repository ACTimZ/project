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
        $favorites = $request->user()->favorites()->with('flat')->get();

        return response()->json($favorites);
    }

    /**
     * Добавить квартиру в избранное
     */
    public function store(Request $request, Flat $flat)
    {
        $existingFavorite = $request->user()
            ->favorites()
            ->where('flat_id', $flat->id)
            ->first();

        if ($existingFavorite) {
            return response()->json([
                'message' => 'Эта квартира уже в избранном'
            ], 422);
        }

        $favorite = $request->user()->favorites()->create([
            'flat_id' => $flat->id
        ]);

        return response()->json([
            'message' => 'Квартира добавлена в избранное',
            'favorite' => $favorite
        ], 201);
    }

    /**
     * Удалить квартиру из избранного
     */
    public function destroy(Request $request, Flat $flat)
    {
        $request->user()
            ->favorites()
            ->where('flat_id', $flat->id)
            ->delete();

        return response()->json([
            'message' => 'Квартира удалена из избранного'
        ]);
    }
}
