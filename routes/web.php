<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ChangeRequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes(['register' => false]); // Users cannot register themselves

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Logged-in users only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

    // Dashboard route for logged-in users
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Pending & Completed filters
    Route::get('change-requests/pending', [ChangeRequestController::class, 'pending'])
    ->name('change-requests.pending')
    ->middleware('auth');

    Route::get('change-requests/completed', [ChangeRequestController::class, 'completed'])
    ->name('change-requests.completed')
    ->middleware('auth');

    // Change Request routes
    Route::resource('change-requests', ChangeRequestController::class);

    // User management (optional: restrict by role later)
    Route::resource('users', UserController::class);

    // Report routes
    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/download', [\App\Http\Controllers\ReportController::class, 'downloadPdf'])->name('reports.downloadPdf');

    // Test email sending
    Route::get('/test-email', function () {
        Mail::raw('This is a test email from SmartCR.', function ($message) {
            $message->to('yourfriend@example.com') // 🔄 Change to a real email
                    ->subject('SmartCR Test Email');
        });

        return 'Email sent!';
    });
});
