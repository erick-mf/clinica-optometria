<?php

namespace App\Providers;

use App\Repositories\Doctor\DoctorRepositoryInterface;
use App\Repositories\Doctor\EloquentDoctorRepository;
use App\Repositories\Schedule\EloquentScheduleRepository;
use App\Repositories\Schedule\ScheduleRepositoryInterface;
use App\Repositories\Patient\EloquentPatientRepository;
use App\Repositories\Patient\PatientRepositoryInterface;
use App\Repositories\Appointment\EloquentAppointmentRepository;
use App\Repositories\Appointment\AppointmentRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DoctorRepositoryInterface::class, EloquentDoctorRepository::class);
        $this->app->bind(ScheduleRepositoryInterface::class, EloquentScheduleRepository::class);
        $this->app->bind(PatientRepositoryInterface::class, EloquentPatientRepository::class);
        $this->app->bind(AppointmentRepositoryInterface::class, EloquentAppointmentRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
