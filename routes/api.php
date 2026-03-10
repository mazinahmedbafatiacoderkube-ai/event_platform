<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendeeController;

Route::post('/login', [AuthController::class,'login']);
Route::post('/register', [AuthController::class,'register']);

Route::get('/test', function () {
    return response()->json([
        'message' => 'API working'
    ]);
});

Route::middleware(['auth:sanctum','throttle:100,1'])->group(function () {

    Route::get('/events', [EventController::class,'index']);
    Route::post('/events', [EventController::class,'store']);
    Route::get('/events/{id}', [EventController::class,'show']);
    Route::put('/events/{id}', [EventController::class,'update']);
    Route::delete('/events/{id}', [EventController::class,'destroy']);

    Route::get('/events/{id}/attendees',[AttendeeController::class,'index']);
    Route::post('/events/{id}/attendees',[AttendeeController::class,'store']);

});