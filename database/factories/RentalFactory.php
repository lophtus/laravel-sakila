<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sakila\Customer;
use App\Sakila\Inventory;
use App\Sakila\Rental;
use App\Sakila\Staff;
use Faker\Generator as Faker;

$factory->define(Rental::class, function (Faker $faker) {
    return [
        'rental_date' => $faker->dateTime,
        'inventory_id' => factory(Inventory::class),
        'customer_id' => factory(Customer::class),
        'return_date' => $faker->optional()->dateTime,
        'staff_id' => factory(Staff::class),
    ];
});
