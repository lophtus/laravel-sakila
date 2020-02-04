<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sakila\Address;
use App\Sakila\City;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'address' => $faker->streetAddress,
        'address2' => $faker->optional()->secondaryAddress,
        'district' => $faker->stateAbbr,
        'city_id' => factory(City::class),
        'postal_code' => $faker->optional()->postcode,
        'phone' => $faker->numerify('###-###-####'),
    ];
});
