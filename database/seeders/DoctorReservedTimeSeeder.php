<?php

namespace Database\Seeders;

use App\Models\DoctorReservedTime;
use Illuminate\Database\Seeder;

class DoctorReservedTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DoctorReservedTime::factory()->count(10)->create();
    }
}
