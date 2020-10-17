<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sakila\Address;
use App\Sakila\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->optional()->email,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'address_id' => factory(Address::class),
        'active' => $faker->boolean,
    ];
});
