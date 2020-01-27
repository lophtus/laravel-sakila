<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sakila\Language;
use Faker\Generator as Faker;

$factory->define(Language::class, function (Faker $faker) {
    return [
        'name' => $faker->languageCode,
    ];
});
