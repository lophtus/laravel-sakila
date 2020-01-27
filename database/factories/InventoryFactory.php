<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sakila\Film;
use App\Sakila\Inventory;
use App\Sakila\Store;
use Faker\Generator as Faker;

$factory->define(Inventory::class, function (Faker $faker) {
    return [
        'film_id' => factory(Film::class),
        'store_id' => factory(Store::class),
    ];
});
