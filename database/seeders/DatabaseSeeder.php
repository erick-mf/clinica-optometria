<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (env('APP_ENV') === 'local') {
            $this->call([
                AdminUserSeeder::class,
                UserSeeder::class,
                PatientSeeder::class,
                AvailableDateSeeder::class,
                AvailableHourSeeder::class,
                TimeSlotSeeder::class,
                AppointmentSeeder::class,
                DoctorAvailableHourSeeder::class,
                OfficeSeeder::class,
            ]);
        } else {
            if (! User::where('email', 'admin@example.com')->exists()) {
                $this->call(AdminUserSeeder::class);
            }
        }
    }
}
