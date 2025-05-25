<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\Sensor;

class MessageSeeder extends Seeder
{
    public function run()
    {
        // Get a sensor (Modify if you need multiple sensors)
        $sensor = Sensor::first();

        if (!$sensor) {
            return;
        }

        // Insert predefined messages
        $messages = [
            ['sensor_id' => $sensor->id, 'severity' => 'Low', 'message' => 'Water level is stable. No action needed.'],
            ['sensor_id' => $sensor->id, 'severity' => 'Medium', 'message' => 'Water level rising. Please monitor closely.'],
            ['sensor_id' => $sensor->id, 'severity' => 'High', 'message' => 'Severe flooding detected! Immediate evacuation recommended.']
        ];

        Message::insert($messages);
    }
}