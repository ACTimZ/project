<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AppealFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'type' => fake()->randomElement(['вопрос', 'отзыв', 'квартира']),
            'message' => fake()->realText(100),
        ];
    }
}
