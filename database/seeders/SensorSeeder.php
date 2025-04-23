<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Sensor;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sensor::insert([
            [
                'name' => 'Flood Sensor A',
                'type' => 'Water Level',
                'location' => 'Angono Baytown',
                'status' => 'active',
                'min_value' => 0,
                'max_value' => 2300,
                'installation_date' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Rain Sensor B',
                'type' => 'Rainfall Detector',
                'location' => 'City Park',
                'status' => 'inactive',
                'min_value' => 5,
                'max_value' => 80,
                'installation_date' => Carbon::now()->subDays(30),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ground Sensor C',
                'type' => 'Soil Moisture',
                'location' => 'Farmland South',
                'status' => 'active',
                'min_value' => 15,
                'max_value' => 70,
                'installation_date' => Carbon::now()->subDays(90),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

    }
}
