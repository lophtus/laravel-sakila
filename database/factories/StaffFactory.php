<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sakila\Address;
use App\Sakila\Staff;
use App\Sakila\Store;
use Faker\Generator as Faker;

$factory->define(Staff::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'address_id' => factory(Address::class),
        'email' => $faker->optional()->email,
        'store_id' => factory(Store::class),
        'active' => $faker->boolean,
        'username' => $faker->userName,
        'password' => $faker->optional()->password,
    ];
});
