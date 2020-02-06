<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sakila\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'address' => $faker->streetAddress,
        'address2' => $faker->optional()->secondaryAddress,
        'city' => $faker->city,
        'state' => $faker->stateAbbr,
        'country' => 'US',
        'postal_code' => $faker->optional()->postcode,
        'phone' => $faker->numerify('###-###-####'),
    ];
});
