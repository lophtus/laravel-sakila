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
        factory(Actor::class, 100)->create();
    }
}
