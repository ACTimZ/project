<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FlatController extends Controller
{
    public function index()
    {
        $flats = Flat::latest()->get();
        return response()->json($flats);
    }

    public function store(Request $request)
    {
        $request->validate([
            'rooms_count' => 'required|integer',
            'square_meters' => 'required|numeric',
            'floor' => 'required|integer',
            'floors_in_house' => 'required|integer',
            'housing_complex' => 'required|string',
            'price_current' => 'required|numeric',
            'has_balcony' => 'required|boolean',
            'bathroom_combined' => 'required|boolean',
            'house_type' => 'required|in:brick,panel,aerated_concrete',
            'description' => 'required|string',
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
            'rooms_count' => $request->rooms_count,
            'square_meters' => $request->square_meters,
            'floor' => $request->floor,
            'floors_in_house' => $request->floors_in_house,
            'housing_complex' => $request->housing_complex,
            'price_current' => $request->price_current,
            'price_start' => $request->price_current,
            'has_balcony' => $request->has_balcony,
            'bathroom_combined' => $request->bathroom_combined,
            'house_type' => $request->house_type,
            'description' => $request->description,
            'images' => $imagePaths
        ]);

        return response()->json($flat, 201);
    }

    public function show(Flat $flat)
    {
        return response()->json($flat);
    }

    public function update(Request $request, Flat $flat)
    {
        $request->validate([
            'rooms_count' => 'sometimes|required|integer',
            'square_meters' => 'sometimes|required|numeric',
            'floor' => 'sometimes|required|integer',
            'floors_in_house' => 'sometimes|required|integer',
            'housing_complex' => 'sometimes|required|string',
            'price_current' => 'sometimes|required|numeric',
            'has_balcony' => 'sometimes|required|boolean',
            'bathroom_combined' => 'sometimes|required|boolean',
            'house_type' => 'sometimes|required|in:brick,panel,aerated_concrete',
            'description' => 'sometimes|required|string',
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
