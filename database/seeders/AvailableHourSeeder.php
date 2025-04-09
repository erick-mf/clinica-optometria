<?php

namespace Database\Seeders;

use App\Models\AvailableHour;
use Illuminate\Database\Seeder;

class AvailableHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AvailableHour::factory(30)->create();
    }
}
