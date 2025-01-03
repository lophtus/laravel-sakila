<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LanguageSeeder::class);
        $this->call(ActorSeeder::class);
        $this->call(FilmSeeder::class);
        $this->call(StoreSeeder::class);
    }
}
