<?php

namespace Database\Factories;

use App\Sakila\Film;
use App\Sakila\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class FilmFactory extends Factory
{
    protected $model = Film::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->company,
            'description' => fake()->optional()->paragraph,
            'release_year' => fake()->optional()->year,
            'language_id' => Language::factory(),
            'original_language_id' => fake()->optional()->randomElement([Language::factory()]),
            'length' => fake()->numberBetween(10, 200),
            'rating' => fake()->optional()->randomElement(Film::RATINGS),
            'special_features' => fake()->optional()->randomElement(Film::SPECIAL_FEATURES),
        ];
    }
}
