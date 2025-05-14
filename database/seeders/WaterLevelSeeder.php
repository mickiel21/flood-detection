<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WaterLevel;

class WaterLevelSeeder extends Seeder
{
    public function run()
    {
        WaterLevel::factory()->count(1000)->create(); // Generate 1000 random records
    }
}