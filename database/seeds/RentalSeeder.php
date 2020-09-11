<?php

use App\Sakila\Customer;
use App\Sakila\Inventory;
use App\Sakila\Rental;
use App\Sakila\Store;
use Illuminate\Database\Seeder;

class RentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $storeId = (int)$this->command->ask('What store do you want to seed? Default: ', 1);

        $store = Store::find($storeId);

        if (! $store) {
            $this->command->error(sprintf('Could not find store \'%s\'', $storeId));
            return;
        }

        $store->customers()->each(function (Customer $customer) use ($store) {
            $store->inventory()
                ->orderByRaw('RAND()')
                ->take(10)
                ->get()
                ->each(function (Inventory $inventory) use ($customer, $store) {
                    if ($inventory->isInStock()) {
                        $rental = factory(Rental::class)->create([
                            'customer_id' => $customer->customer_id,
                            'inventory_id' => $inventory->inventory_id,
                            'staff_id' => $store->staff()->orderByRaw('RAND()')->first()->staff_id,
                        ]);

                        $this->command->info(sprintf('Added rental for customer \'%s\'.', $customer->customer_id));
                    }
                });
        });
    }
}
