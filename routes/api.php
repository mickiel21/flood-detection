<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FloodDetectionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('/email-notification', [FloodDetectionController::class, 'testEmailNotification']);
Route::post('/sms-notification', [FloodDetectionController::class, 'testSmsNotification']);


Route::middleware(['cors'])->group(function () {
    Route::post('/water-level', [FloodDetectionController::class, 'store']);
});