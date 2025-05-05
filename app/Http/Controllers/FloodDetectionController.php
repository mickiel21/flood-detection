<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\FloodAlertNotification;
use App\Notifications\SMSNotification;
use App\Models\User;
use App\Events\WaterLevel;
use Illuminate\Support\Facades\Log;

class FloodDetectionController extends Controller
{
   public function store(Request $request){
      Log::info("Water Level Value: " . $request->water_level);

      event(new WaterLevel($request->water_level));
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

}
