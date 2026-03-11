<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AnalyticsController;

Route::get('/', function () {
    return view('auth.login');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'registerPage'])->name('register.page');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (Require Login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | EVENTS
    |--------------------------------------------------------------------------
    */

    Route::get('/events',[EventController::class,'index']);

    Route::get('/events/create',[EventController::class,'create']);

    Route::post('/events',[EventController::class,'store']);

    Route::get('/events/{id}',[EventController::class,'show']);

    Route::get('/events/{id}/edit',[EventController::class,'edit']);

    Route::put('/events/{id}',[EventController::class,'update']);

    Route::delete('/events/{id}',[EventController::class,'destroy']);


    /*
    |--------------------------------------------------------------------------
    | ATTENDEES
    |--------------------------------------------------------------------------
    */

    Route::get('/attendees',[AttendeeController::class,'index']);


    /*
    |--------------------------------------------------------------------------
    | CHAT
    |--------------------------------------------------------------------------
    */

    Route::get('/chat',[ChatController::class,'index']);


    /*
    |--------------------------------------------------------------------------
    | ANALYTICS
    |--------------------------------------------------------------------------
    */

    Route::get('/analytics',[AnalyticsController::class,'index']);

});
