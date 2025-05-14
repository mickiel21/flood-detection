<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sensor;
use App\Models\Alert;

class WaterLevel extends Model
{
    use HasFactory;
    protected $fillable = ['sensor_id', 'level', 'measured_at', 'alert_id'];

    // Relationship with Sensor
    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }

    // Relationship with Alert
    public function alert()
    {
        return $this->belongsTo(Alert::class);
    }

}
