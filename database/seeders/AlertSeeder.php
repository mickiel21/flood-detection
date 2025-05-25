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
            ],
        ]);

    }
}
