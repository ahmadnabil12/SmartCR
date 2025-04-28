<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AcademicianController;
use App\Http\Controllers\GrantController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

/*Route::middleware(['auth'])->get('/dashboard', function () {
    return view('dashboard');
});*/

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('academicians', AcademicianController::class);
Route::resource('grants', GrantController::class);
Route::resource('milestones', MilestoneController::class);

Route::middleware(['can:AdminAcademicianStaff'])->group(function () {
    // Admin routes to manage academicians
    Route::resource('academicians', AcademicianController::class);
    Route::resource('grants', GrantController::class);
    Route::resource('milestones', MilestoneController::class);
});

Route::get('/grants/{grant}', [GrantController::class, 'show'])->name('grants.show');

/*Route::middleware(['auth'])->group(function () {
    Route::get('/grants/{grant}', [GrantController::class, 'show'])
        ->middleware('can:isMember,grant');

    Route::get('/grants/{grant}/edit', [GrantController::class, 'edit'])
        ->middleware('can:isLeader,grant');

});*/
