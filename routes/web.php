<?php

use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('doctor.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('setup-password/{token}', [App\Http\Controllers\Auth\SetupPasswordController::class, 'showSetupForm'])->name('password.setup');
Route::post('setup-password', [App\Http\Controllers\Auth\SetupPasswordController::class, 'setup'])->name('password.setup.update');
Route::get('setup-password-complete', function () {
    return view('auth.passwords.setup-complete');
})->name('password.setup.complete');
// routes admin
Route::prefix('admin')->name('admin.')->middleware('auth', 'verified', 'admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('doctors', DoctorController::class);
    Route::get('doctors/search', [DoctorController::class, 'search'])->name('admin.doctors.search');
    Route::resource('schedules', ScheduleController::class);
    Route::resource('patients', PatientController::class);
    Route::resource('appointments', AppointmentController::class);
});
// routes/web.php
Route::get('/test/401', function () {
    abort(401);
});
Route::get('/test/403', function () {
    abort(403);
});
Route::get('/test/404', function () {
    abort(404);
});
Route::get('/test/419', function () {
    abort(419);
});
Route::get('/test/429', function () {
    abort(429);
});
Route::get('/test/500', function () {
    abort(500);
});
Route::get('/test/503', function () {
    abort(503);
});
