<?php

namespace Database\Seeders;

use App\Models\DoctorAvailableHour;
use Illuminate\Database\Seeder;

class DoctorAvailableHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DoctorAvailableHour::factory(10)->create();
    }
}
