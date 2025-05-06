<?php

namespace Database\Factories;

use App\Models\Favorite;
use App\Models\User;
use App\Models\Flat;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'flat_id' => Flat::inRandomOrder()->first()->id ?? Flat::factory(),
        ];
    }
}
