<?php

namespace Database\Factories;

use App\Sakila\Film;
use App\Sakila\Inventory;
use App\Sakila\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryFactory extends Factory
{
    protected $model = Inventory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'film_id' => Film::factory(),
            'store_id' => Store::factory(),
        ];
    }
}
