<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flat;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $favorites = $request->user()->favorites()->with('flat')->get();
        return response()->json($favorites);
    }

    public function store(Request $request, Flat $flat)
    {
        $favorite = $request->user()->favorites()->where('flat_id', $flat->id)->first();

        if ($favorite) {
            return response()->json([
                'message' => 'Квартира уже в избранном'
            ], 422);
        }

        $request->user()->favorites()->create([
            'flat_id' => $flat->id
        ]);

        return response()->json([
            'message' => 'Квартира добавлена в избранное'
        ]);
    }

    public function destroy(Request $request, Flat $flat)
    {
        $request->user()->favorites()->where('flat_id', $flat->id)->delete();

        return response()->json([
            'message' => 'Квартира удалена из избранного'
        ]);
    }
}
