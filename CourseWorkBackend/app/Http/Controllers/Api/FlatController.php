<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FlatController extends Controller
{
    public function index(Request $request)
    {
        $query = Flat::query();

        if ($request->filled('rooms_count')) {
            $query->where('rooms_count', $request->rooms_count);
        }
        if ($request->filled('floor')) {
            $query->where('floor', $request->floor);
        }
        if ($request->filled('housing_complex')) {
            $query->where('housing_complex', 'like', '%' . $request->housing_complex . '%');
        }
        if ($request->filled('house_type')) {
            $query->where('house_type', 'like', '%' . $request->house_type . '%');
        }
        if ($request->filled('price_min')) {
            $query->where('price_current', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price_current', '<=', $request->price_max);
        }
        if ($request->filled('price_per_m2_min')) {
            $query->whereRaw('price_current / square_meters >= ?', [$request->price_per_m2_min]);
        }
        if ($request->filled('price_per_m2_max')) {
            $query->whereRaw('price_current / square_meters <= ?', [$request->price_per_m2_max]);
        }
        if ($request->filled('bathroom_combined')) {
            $query->where('bathroom_combined', $request->bathroom_combined);
        }
        if ($request->filled('has_balcony')) {
            $query->where('has_balcony', $request->has_balcony);
        }

        $flats = $query->paginate(10);

        return response()->json($flats);
    }

    public function show(Flat $flat)
    {
        return response()->json($flat);
    }

    public function store(Request $request)
    {
        $request->validate([
            'rooms_count' => 'required|integer|min:1',
            'square_meters' => 'required|numeric|min:1',
            'floor' => 'required|integer|min:1',
            'floors_in_house' => 'required|integer|min:1',
            'housing_complex' => 'required|string|max:255',
            'price_current' => 'required|numeric|min:0',
            'has_balcony' => 'required|boolean',
            'bathroom_combined' => 'required|boolean',
            'house_type' => 'required|in:brick,panel,aerated_concrete',
            'description' => 'required|string',
            'images' => 'required|array|size:4',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('flats', 'public');
                $imagePaths[] = $path;
            }
        }

        $flat = Flat::create([
            ...$request->except('images'),
            'price_start' => $request->price_current,
            'images' => $imagePaths
        ]);

        return response()->json($flat, 201);
    }

    public function update(Request $request, Flat $flat)
    {
        $request->validate([
            'rooms_count' => 'sometimes|required|integer|min:1',
            'square_meters' => 'sometimes|required|numeric|min:1',
            'floor' => 'sometimes|required|integer|min:1',
            'floors_in_house' => 'sometimes|required|integer|min:1',
            'housing_complex' => 'sometimes|required|string|max:255',
            'price_current' => 'sometimes|required|numeric|min:0',
            'has_balcony' => 'sometimes|required|boolean',
            'bathroom_combined' => 'sometimes|required|boolean',
            'house_type' => 'sometimes|required|in:brick,panel,aerated_concrete',
            'description' => 'sometimes|required|string',
            'images' => 'sometimes|array|size:4',
            'images.*' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('images')) {
            foreach ($flat->images as $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('flats', 'public');
                $imagePaths[] = $path;
            }
            $request->merge(['images' => $imagePaths]);
        }

        $flat->update($request->all());
        return response()->json($flat);
    }

    public function destroy(Flat $flat)
    {
        foreach ($flat->images as $image) {
            Storage::disk('public')->delete($image);
        }

        $flat->delete();
        return response()->json(null, 204);
    }
}
