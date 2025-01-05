<?php

namespace Database\Factories;

use App\Sakila\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address' => fake()->streetAddress,
            'address2' => fake()->optional()->secondaryAddress,
            'city' => fake()->city,
            'state' => fake()->stateAbbr,
            'country' => 'US',
            'postal_code' => fake()->postcode,
            'phone' => fake()->numerify('###-###-####'),
        ];
    }
}
