<?php

namespace Database\Seeders;

use App\Sakila\Actor;
use Illuminate\Database\Seeder;

class ActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Actor::factory()
            ->count(100)
            ->create();
    }
}
