<?php

namespace App\Providers;

use App\Repositories\Appointment\AppointmentRepositoryInterface;
use App\Repositories\Appointment\EloquentAppointmentRepository;
use App\Repositories\AvailableDate\AvailableDateRepositoryInterface;
use App\Repositories\AvailableDate\EloquentAvailableDateRepository;
use App\Repositories\AvailableHour\AvailableHourRepositoryInterface;
use App\Repositories\AvailableHour\EloquentAvailableHourRepository;
use App\Repositories\Doctor\DoctorRepositoryInterface;
use App\Repositories\Doctor\EloquentDoctorRepository;
use App\Repositories\DoctorReservedTime\DoctorReservedTimeRepositoryInterface;
use App\Repositories\DoctorReservedTime\EloquentDoctorReservedTimeRepository;
use App\Repositories\Office\EloquentOfficeRepository;
use App\Repositories\Office\OfficeRepositoryInterface;
use App\Repositories\Patient\EloquentPatientRepository;
use App\Repositories\Patient\PatientRepositoryInterface;
use App\Repositories\TimeSlot\EloquentTimeSlotRepository;
use App\Repositories\TimeSlot\TimeSlotRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DoctorRepositoryInterface::class, EloquentDoctorRepository::class);
        $this->app->bind(PatientRepositoryInterface::class, EloquentPatientRepository::class);
        $this->app->bind(AppointmentRepositoryInterface::class, EloquentAppointmentRepository::class);
        $this->app->bind(AvailableDateRepositoryInterface::class, EloquentAvailableDateRepository::class);
        $this->app->bind(AvailableHourRepositoryInterface::class, EloquentAvailableHourRepository::class);
        $this->app->bind(TimeSlotRepositoryInterface::class, EloquentTimeSlotRepository::class);
        $this->app->bind(OfficeRepositoryInterface::class, EloquentOfficeRepository::class);
        $this->app->bind(DoctorReservedTimeRepositoryInterface::class, EloquentDoctorReservedTimeRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
