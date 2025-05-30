<?php

use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\ClinicInfoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\ReservedTimeController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\SetupPasswordController;
use App\Http\Controllers\BookAppointmentController;
use App\Http\Controllers\Doctor\AppointmentController as DoctorAppointment;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboard;
use App\Http\Controllers\Doctor\PatientController as DoctorPatient;
use App\Http\Controllers\Doctor\ReservedTimesController as DoctorReservedTimes;
use App\Http\Controllers\Doctor\ScheduleController as DoctorSchedule;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/book-appointment', [BookAppointmentController::class, 'index'])->name('book-appointment');
Route::post('/book-appointment', [BookAppointmentController::class, 'store'])->name('book-appointment.store');
Route::get('/api/available-slots/{date}', [BookAppointmentController::class, 'getAvailableSlots'])->middleware('throttle:10,1', 'verify.appointment.token');

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

// setup password
Route::get('setup-password/{token}', [SetupPasswordController::class, 'showSetupForm'])->name('password.setup');
Route::post('setup-password', [SetupPasswordController::class, 'setup'])->name('password.setup.update');
Route::get('setup-password-complete', function () {
    return view('auth.passwords.setup-complete');
})->name('password.setup.complete');

// routes admin
Route::prefix('admin')->name('admin.')->middleware('auth', 'verified', 'admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('doctors/{doctor}/resend-setup-link', [DoctorController::class, 'resendSetupLink'])->name('doctors.resendSetupLink');
    Route::resource('doctors', DoctorController::class);
    Route::resource('patients', PatientController::class);
    Route::delete('schedules/destroy-all', [ScheduleController::class, 'destroyAll'])->name('schedules.destroyAll');
    Route::resource('schedules', ScheduleController::class);
    Route::get('appointments/create/{patient}', [AppointmentController::class, 'create'])->name('appointments.create.withPatient');
    Route::resource('appointments', AppointmentController::class);
    Route::resource('offices', OfficeController::class);
    Route::get('reserved-times', [ReservedTimeController::class, 'index'])->name('reserved-times.index');
    Route::delete('reserved-times/{id}', [ReservedTimeController::class, 'destroy'])->name('reserved-times.destroy');

    Route::get('clinic-info', [ClinicInfoController::class, 'index'])->name('clinic-info.index');
    Route::get('clinic-info/configure', [ClinicInfoController::class, 'create'])->name('clinic-info.configure');
    Route::match(['post', 'put'], 'clinic-info', [ClinicInfoController::class, 'storeOrUpdate'])->name('clinic-info.save');
});

// routes doctor
Route::middleware('auth', 'verified', 'doctor')->group(function () {
    Route::get('dashboard', [DoctorDashboard::class, 'index'])->name('dashboard');
    Route::resource('patients', DoctorPatient::class);
    Route::get('appointments/create/{patient}', [DoctorAppointment::class, 'create'])->name('appointments.create.withPatient');
    Route::resource('appointments', DoctorAppointment::class);
    Route::get('/schedule', [DoctorSchedule::class, 'index'])->name('schedules.index');
    Route::resource('reserved-times', DoctorReservedTimes::class);
});

Route::get('/cancel-appointment/{token}', [BookAppointmentController::class, 'showCancel'])->name('appointments.cancel');
Route::post('/cancel-appointment/{token}', [BookAppointmentController::class, 'cancel'])->name('appointments.cancel.confirm');
