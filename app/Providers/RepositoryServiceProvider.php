<?php

namespace App\Providers;

use App\Repositories\Doctor\DoctorRepositoryInterface;
use App\Repositories\Doctor\EloquentDoctorRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DoctorRepositoryInterface::class, EloquentDoctorRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
