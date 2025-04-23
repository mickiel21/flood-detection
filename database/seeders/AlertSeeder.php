<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alert;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Alert::insert([
            [
                'sensor_id' => 1,
                'type' => 'Flood Warning',
                'severity' => 'High',
                'message' => 'Water level exceeds maximum threshold!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sensor_id' => 1,
                'type' => 'Low Water Level',
                'severity' => 'Medium',
                'message' => 'Water level is below minimum threshold.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sensor_id' => 1,
                'type' => 'Sensor Disconnected',
                'severity' => 'Critical',
                'message' => 'Sensor is offline, check connections.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}
