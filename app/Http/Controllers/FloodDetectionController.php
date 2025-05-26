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
  

public function store(Request $request){
    Log::info("Water Level Value: " . $request->water_level);

    event(new WaterLevelEvents($request->water_level));

    WaterLevel::create([
        'sensor_id' => 1,
        'level' => $request->water_level,
        'measured_at' => now(),
        'alert_id' => 1, 
    ]);

    $users = User::all();
    
    // Get the last recorded water level from cache
    $lastWaterLevel = Cache::get('last_water_level', null);

    // Only send notification if there's a significant change **AND** it has been at least 5 seconds
    if ($lastWaterLevel === null || abs($request->water_level - $lastWaterLevel) >= 1) {
        // Store the new water level in cache with a **5-second expiration**
        Cache::put('last_water_level', $request->water_level, now()->addSeconds(15));

        // Notify based on water level
        if ($request->water_level = 6) {
            foreach ($users as $user) {
                $user->notify(new FloodAlertNotification('Low'));
            }
        } elseif ($request->water_level = 12) {
            foreach ($users as $user) {
                $user->notify(new FloodAlertNotification('Medium'));
            }
        } elseif ($request->water_level = 19) {
            foreach ($users as $user) {
                $user->notify(new FloodAlertNotification('High'));
            }
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
    $user = User::find(2);
    $user->notify(new SMSNotification($request->severity));
    echo 'sms working';
   }

   public function testSemaphore(Request $request){
    $user = User::find(1);
    $user->notify(new SemaphoreSMSNotification( 'Flood Alert: Heavy rains detected!'));
    echo 'semaphore working';
   }




}
