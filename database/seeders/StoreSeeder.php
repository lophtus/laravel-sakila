<?php

namespace Database\Seeders;

use App\Sakila\Customer;
use App\Sakila\Film;
use App\Sakila\Staff;
use App\Sakila\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storeCount = (int)$this->command->ask('How many stores do you need? Default: ', 1);
        $staffCount = (int)$this->command->ask('How many staff members do you need (excl. manager)? Default: ', 5);
        $customerCount = (int)$this->command->ask('How many customers do you need? Default: ', 20);
        $inventoryCount = (int)$this->command->ask('How much inventory do you need? Default: ', 100);

        Store::factory()->count($storeCount)->create()
            ->each(function (Store $store) use ($staffCount, $customerCount, $inventoryCount) {

                $this->command->info(sprintf("Created %s store(s)'", $store->store_id));

                $store->manager()->associate(Staff::factory()->create(['store_id' => $store->store_id]));
                $store->save();

                $store->staff()->saveMany(Staff::factory()->count($staffCount)->make());

                $this->command->info(sprintf("Added %s staff member(s)", $staffCount));

                $store->customers()->saveMany(Customer::factory()->count($customerCount)->create());

                $this->command->info(sprintf("Added %s customer(s)", $customerCount));

                Film::orderByRaw('RAND()')
                    ->take($inventoryCount)
                    ->get()
                    ->each(function (Film $film) use ($store) {
                        $store->inventory()->create([
                            'film_id' => $film->film_id,
                        ]);
                    });

                $this->command->info(sprintf("Added %s inventory", $inventoryCount));
            });
    }
}
