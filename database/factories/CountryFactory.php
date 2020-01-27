<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sakila\Country;
use Faker\Generator as Faker;

$factory->define(Country::class, function (Faker $faker) {
    return [
        'country' => $faker->country,
    ];
});
