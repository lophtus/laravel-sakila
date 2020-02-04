<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sakila\Address;
use App\Sakila\Staff;
use App\Sakila\Store;
use Faker\Generator as Faker;

$factory->define(Store::class, function (Faker $faker) {
    return [
        'address_id' => factory(Address::class),
    ];
});
