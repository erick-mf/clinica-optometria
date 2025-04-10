<?php

use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboard;
use App\Http\Controllers\Doctor\AppointmentController as DoctorAppointment;
use App\Http\Controllers\Doctor\PatientController as DoctorPatient;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/book-appointment', function () {
    return view('book-appointment');
})->name('book-appointment');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/terms-conditions', function () {
    return view('terms-conditions');
})->name('terms-conditions');

Route::post('/contact/send', [\App\Http\Controllers\Contact\ContactController::class, 'send'])->name('contact.send');

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

// routes doctor
Route::middleware('auth', 'verified', 'doctor')->group(function () {
    Route::get('dashboard', [DoctorDashboard::class, 'index'])->name('dashboard');
    Route::resource('appointments', DoctorAppointment::class);
    Route::resource('patients', DoctorPatient::class);
});
