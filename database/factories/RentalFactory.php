<?php

namespace Database\Factories;

use App\Sakila\Customer;
use App\Sakila\Inventory;
use App\Sakila\Rental;
use App\Sakila\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;


class RentalFactory extends Factory
{
    protected $model = Rental::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rental_date' => fake()->dateTime,
            'inventory_id' => Inventory::factory(),
            'customer_id' => Customer::factory(),
            'return_date' => fake()->optional()->dateTime,
            'staff_id' => Staff::factory(),
        ];
    }
}
