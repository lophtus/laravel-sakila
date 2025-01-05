<?php

namespace Database\Seeders;

use App\Sakila\Payment;
use App\Sakila\Rental;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rentalId = (int)$this->command->ask('What rental do you want to seed? Default: ', 1);

        $rental = Rental::find($rentalId);

        if (! $rental) {
            $this->command->error(sprintf('Could not find rental \'%s\'.', $rentalId));
            return;
        }

        if ($rental->payment()->exists()) {
            $this->command->error('A payment already exists for the specified rental.');
            return;
        }

        $payment = Payment::factory()->create([
            'rental_id' => $rental->rental_id,
            'staff_id' => $rental->staff_id,
            'customer_id' => $rental->customer_id,
        ]);

        $this->command->info(sprintf('A payment \'%s\' was created successfully.', $payment->payment_id));
    }
}
