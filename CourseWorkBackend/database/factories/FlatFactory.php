<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FlatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rooms_count' => fake()->numberBetween(1, 5),
            'square_meters' => fake()->numberBetween(30, 150),
            'floor' => fake()->numberBetween(1, 20),
            'floors_in_house' => fake()->numberBetween(5, 25),
            'housing_complex' => fake()->words(2, true),
            'price_current' => fake()->numberBetween(3000000, 20000000),
            'price_start' => fake()->numberBetween(2500000, 18000000),
            'has_balcony' => fake()->boolean(),
            'bathroom_combined' => fake()->boolean(),
            'house_type' => fake()->randomElement(['Кирпичный', 'Панельный', 'Газобетонный']),
            'description' => fake()->paragraph(),
            'images' => [
                'https://i.pinimg.com/originals/c5/86/a4/c586a4b4c399ed8cc75b78e536ec249a.jpg',
                'https://i.pinimg.com/originals/c5/86/a4/c586a4b4c399ed8cc75b78e536ec249a.jpg',
                'https://i.pinimg.com/originals/c5/86/a4/c586a4b4c399ed8cc75b78e536ec249a.jpg',
                'https://i.pinimg.com/originals/c5/86/a4/c586a4b4c399ed8cc75b78e536ec249a.jpg',
            ],
        ];
    }
}
