<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RolesSeeder;
use Database\Seeders\AlertSeeder;
use Database\Seeders\SensorSeeder;
use Database\Seeders\WaterLevelSeeder;
use Database\Seeders\MessageSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            UserSeeder::class,
            SensorSeeder::class,
            AlertSeeder::class,
            WaterLevelSeeder::class,
            MessageSeeder::class,
        ]);
    }
}
