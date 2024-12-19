<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sakila\Film;
use App\Sakila\Language;
use Faker\Generator as Faker;

$factory->define(Film::class, function (Faker $faker) {
    return [
        'title' => $faker->company,
        'description' => $faker->optional()->paragraph,
        'release_year' => $faker->optional()->year,
        'language_id' => factory(Language::class),
        'original_language_id' => $faker->optional()->randomElement([factory(Language::class)]),
        'length' => $faker->numberBetween(10, 200),
        'rating' => $faker->optional()->randomElement(Film::RATINGS),
        'special_features' => $faker->optional()->randomElement(Film::SPECIAL_FEATURES),
    ];
});
