<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sakila\City;
use App\Sakila\Country;
use Faker\Generator as Faker;

$factory->define(City::class, function (Faker $faker) {
    return [
        'city' => $faker->city,
        'country_id' => factory(Country::class),
    ];
});
