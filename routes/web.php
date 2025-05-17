<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ChangeRequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes(); // Default Laravel auth routes (register, login, etc.)

//Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Logged-in users only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

    /*Route::get('/home', function () {
        return view('home');
    })->name('home')->middleware('auth');*/

    // Dashboard route for logged-in users
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Change Request routes
    Route::resource('change-requests', ChangeRequestController::class);

    // User management (optional: restrict by role later)
    Route::resource('users', UserController::class);

    // Test email sending
    Route::get('/test-email', function () {
        Mail::raw('This is a test email from SmartCR.', function ($message) {
            $message->to('yourfriend@example.com') // 🔄 Change to a real email
                    ->subject('SmartCR Test Email');
        });

        return '✅ Email sent!';
    });
});
