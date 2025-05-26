<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\FloodAlertNotification;
use App\Notifications\SMSNotification;
use App\Notifications\SemaphoreSMSNotification;
use App\Models\User;
use App\Events\WaterLevel as WaterLevelEvents;
use Illuminate\Support\Facades\Log;
use App\Models\WaterLevel;
 use Illuminate\Support\Facades\Cache;

class FloodDetectionController extends Controller
{
  

   
protected function roundWaterLevel($water_level) {
    // Specific rounding conditions
    if ($water_level >= 19.10 && $water_level <= 19.90) {
        return 19;
    } elseif ($water_level >= 12.10 && $water_level <= 12.90) {
        return round($water_level);
    } elseif ($water_level >= 6.10 && $water_level <= 6.90) {
        return round($water_level);
    }
    
    // Default rounding for other values
    return round($water_level);
}


public function store(Request $request){
    Log::info("Water Level Value: " . $request->water_level);

    //event(new WaterLevelEvents($request->water_level));

    WaterLevel::create([
        'sensor_id' => 1,
        'level' => $request->water_level,
        'measured_at' => now(),
        'alert_id' => 1, 
    ]);

    $users = User::all();

    // Define notification levels
    $alertLevels = [
        6  => 'Low',
        12 => 'Medium',
        19 => 'High'
    ];

    $waterLevel = $this->roundWaterLevel($request->water_level);

    // Check if the water level matches a defined alert level
    if (array_key_exists($waterLevel, $alertLevels)) {
        $cacheKey = "last_notification_{$alertLevels[$waterLevel]}";

        // Get the last notification time from cache
        $lastNotificationTime = Cache::get($cacheKey, null);

        // Only send notification if **5 minutes have passed**
        if ($lastNotificationTime === null || now()->diffInMinutes($lastNotificationTime) >= 5) {
            foreach ($users as $user) {
                $user->notify(new FloodAlertNotification($alertLevels[$waterLevel]));
            }

            // Store the last notification time in cache
            Cache::put($cacheKey, now(), now()->addMinutes(5));
        }
    }

    return response()->json([
        'message' => 'Sensor value received successfully!',
        'data' => $request->all()
    ], 200);
}

   public function testEmailNotification(Request $request){
    $user = User::find(3);
  
    $user->notify(new FloodAlertNotification($request->severity));
    echo 'email working';
   }

   public function testSmsNotification(Request $request){
    $user = User::find(8);
    $user->notify(new SMSNotification($request->severity));
    echo 'sms working';
   }

   public function testSemaphore(Request $request){
    $user = User::find(1);
    $user->notify(new SemaphoreSMSNotification( 'Flood Alert: Heavy rains detected!'));
    echo 'semaphore working';
   }




}
