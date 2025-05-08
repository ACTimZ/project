<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appeal;

class AppealSeeder extends Seeder
{
    public function run(): void
    {
        Appeal::factory()->count(25)->create();
    }
}
