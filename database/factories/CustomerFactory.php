<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sakila\Address;
use App\Sakila\Customer;
use App\Sakila\Store;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'store_id' => factory(Store::class),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->optional()->email,
        'address_id' => factory(Address::class),
        'active' => $faker->boolean,
    ];
});
