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

class FloodDetectionController extends Controller
{
   public function store(Request $request){
      Log::info("Water Level Value: " . $request->water_level);

     event(new WaterLevelEvents($request->water_level));

      WaterLevel::create([
         'sensor_id' => 1,
         'level' => $request->water_level, // Example water level in meters
         'measured_at' => now(),
         'alert_id' => 1, // No alert triggered yet
      ]);

      return response()->json([
         'message' => 'Sensor value received successfully!',
         'data' => $request->all()
      ], 200);
   }

   public function testEmailNotification(Request $request){
    $user = User::find(2);
  
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
