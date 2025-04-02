<?php

namespace App\Providers;

use App\Repositories\Doctor\DoctorRepositoryInterface;
use App\Repositories\Doctor\EloquentDoctorRepository;
use App\Repositories\Schedule\EloquentScheduleRepository;
use App\Repositories\Schedule\ScheduleRepositoryInterface;
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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
