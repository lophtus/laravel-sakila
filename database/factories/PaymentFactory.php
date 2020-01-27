<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sakila\Customer;
use App\Sakila\Payment;
use App\Sakila\Rental;
use App\Sakila\Staff;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'customer_id' => factory(Customer::class),
        'staff_id' => factory(Staff::class),
        'rental_id' => factory(Rental::class),
        'amount' => $faker->randomFloat(5, 2),
        'payment_date' => $faker->dateTime,
    ];
});
