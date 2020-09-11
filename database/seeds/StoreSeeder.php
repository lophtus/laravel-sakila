<?php

use App\Sakila\Customer;
use App\Sakila\Film;
use App\Sakila\Staff;
use App\Sakila\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $storeCount = (int)$this->command->ask('How many stores do you need? Default: ', 1);
        $staffCount = (int)$this->command->ask('How many staff members do you need (excl. manager)? Default: ', 5);
        $customerCount = (int)$this->command->ask('How many customers do you need? Default: ', 20);
        $inventoryCount = (int)$this->command->ask('How much inventory do you need? Default: ', 100);

        factory(Store::class, $storeCount)->create()
            ->each(function (Store $store) use ($staffCount, $customerCount, $inventoryCount) {

                $this->command->info(sprintf("Created %s store(s)'", $store->store_id));

                $store->manager()->associate(factory(Staff::class)->create(['store_id' => $store->store_id]));
                $store->save();

                $store->staff()->saveMany(factory(Staff::class, $staffCount)->make());

                $this->command->info(sprintf("Added %s staff member(s)", $staffCount));

                $store->customers()->saveMany(factory(Customer::class, $customerCount)->make());

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
