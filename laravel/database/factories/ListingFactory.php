<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => ucwords(fake()->words(2, true)) . ' ' . fake()->randomElement(['Apartments', 'Residences', 'Building', 'Condominiums', 'Hall', 'House']),
            'description' => fake()->realText(rand(200, 1000)),
            'beds' => fake()->numberBetween(1, 7),
            'baths' => fake()->numberBetween(1, 4),
            'area' => fake()->numberBetween(30, 255),
            'city' => fake()->city(),
            'code' => fake()->postcode(),
            'street' => fake()->streetName(),
            'street_nr' => fake()->numberBetween(1, 200),
            'price' => fake()->numberBetween(50_000, 2_000_000),
            'enabled' => true,
        ];
    }
}
