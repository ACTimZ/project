<?php

namespace Database\Seeders;

use App\Models\Flat;
use Illuminate\Database\Seeder;

class FlatSeeder extends Seeder
{
    public function run(): void
    {
        Flat::factory(25)->create();
    }
}
