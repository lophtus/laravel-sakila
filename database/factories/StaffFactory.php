<?php

namespace Database\Factories;

use App\Sakila\Address;
use App\Sakila\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    protected $model = Staff::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'address_id' => Address::factory(),
            'email' => fake()->optional()->email,
            'active' => fake()->boolean,
            'username' => fake()->userName,
            'password' => fake()->optional()->password,
        ];
    }
}
