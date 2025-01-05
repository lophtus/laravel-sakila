<?php

namespace Database\Factories;

use App\Sakila\Customer;
use App\Sakila\Payment;
use App\Sakila\Rental;
use App\Sakila\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'staff_id' => Staff::factory(),
            'rental_id' => Rental::factory(),
            'amount' => fake()->randomFloat(5, 2),
            'payment_date' => fake()->dateTime,
        ];
    }
}
