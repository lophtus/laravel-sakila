<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguageSeeder::class);
        $this->call(ActorSeeder::class);
        $this->call(FilmSeeder::class);
        $this->call(StoreSeeder::class);
    }
}
