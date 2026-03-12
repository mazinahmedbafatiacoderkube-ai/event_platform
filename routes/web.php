<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\LandingController;

/*
|--------------------------------------------------------------------------
| HOME (ORGANIZATION LANDING PAGE)
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/organization/{id}', [LandingController::class, 'events'])
    ->name('organization.events');


/*
|--------------------------------------------------------------------------
| BOOK EVENT TICKET (PUBLIC)
|--------------------------------------------------------------------------
*/

/* SHOW BOOK TICKET PAGE */
Route::get('/book-ticket/{event}', [AttendeeController::class, 'index'])
    ->name('book.ticket.page');

/* STORE ATTENDEE */
Route::post('/book-ticket/{event}', [AttendeeController::class, 'store'])
    ->name('ticket.book');


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Guest Only)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'registerPage'])->name('register.page');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');
});


/*
|--------------------------------------------------------------------------
| RESET PASSWORD
|--------------------------------------------------------------------------
*/

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');


Route::post('/reset-password', function (Request $request) {

    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:6',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {

            $user->password = Hash::make($password);
            $user->save();
        }
    );

    if ($status == Password::PASSWORD_RESET) {
        return redirect()->route('login')->with('success', 'Password reset successful');
    }

    return back()->withErrors(['email' => __($status)]);
})->name('password.update');


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | EVENTS MODULE
    |--------------------------------------------------------------------------
    */

    Route::prefix('events')->group(function () {

        Route::get('/', [EventController::class, 'index'])->name('events.index');

        Route::get('/create', [EventController::class, 'create'])->name('events.create');

        Route::post('/', [EventController::class, 'store'])->name('events.store');

        Route::get('/{id}', [EventController::class, 'show'])->name('events.show');

        Route::get('/{id}/edit', [EventController::class, 'edit'])->name('events.edit');

        Route::put('/{id}', [EventController::class, 'update'])->name('events.update');

        Route::delete('/{id}', [EventController::class, 'destroy'])->name('events.destroy');

    });


    /*
    |--------------------------------------------------------------------------
    | STAFF MANAGEMENT
    |--------------------------------------------------------------------------
    */

    Route::prefix('staff')->group(function () {

        Route::get('/', [StaffController::class, 'index'])
            ->name('staff.index');

        Route::post('/', [StaffController::class, 'store'])
            ->name('staff.store');

        Route::delete('/{id}', [StaffController::class, 'destroy'])
            ->name('staff.delete');

    });


    /*
    |--------------------------------------------------------------------------
    | ATTENDEES
    |--------------------------------------------------------------------------
    */

    Route::get('/attendees/{event}', [AttendeeController::class, 'index'])
        ->name('attendees.index');


    /*
    |--------------------------------------------------------------------------
    | CHAT
    |--------------------------------------------------------------------------
    */

    Route::get('/chat', [ChatController::class, 'index'])
        ->name('chat.index');


    /*
    |--------------------------------------------------------------------------
    | ANALYTICS
    |--------------------------------------------------------------------------
    */

    Route::get('/analytics', [AnalyticsController::class, 'index'])
        ->name('analytics.index');
    Route::get('/book', function () {
        return view('landing.book');
    })->name('book');

});
