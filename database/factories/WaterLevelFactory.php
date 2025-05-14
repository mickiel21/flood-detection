<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\WaterLevel;
use App\Models\Sensor;
use App\Models\Alert;
use Carbon\Carbon;

class WaterLevelFactory extends Factory
{
    protected $model = WaterLevel::class;

    public function definition()
    {
        return [
            'sensor_id' => Sensor::inRandomOrder()->first()->id ?? 1, // Random sensor or default to 1
            'level' => $this->faker->numberBetween(1, 400), // Random water level between 1 and 400
            'measured_at' => Carbon::createFromDate(2024, $this->faker->numberBetween(1, 12), $this->faker->numberBetween(1, 28))
                ->setTime($this->faker->numberBetween(0, 23), $this->faker->numberBetween(0, 59)), // Random date & time
            'alert_id' => Alert::inRandomOrder()->first()->id ?? null, // Random alert or null
        ];
    }
}