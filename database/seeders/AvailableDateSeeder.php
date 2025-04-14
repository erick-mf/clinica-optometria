<?php

namespace Database\Seeders;

use App\Models\AvailableDate;
use Illuminate\Database\Seeder;

class AvailableDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i <= 9; $i++) {
            AvailableDate::factory()->create(['date' => '2025-06-1'.$i]);
        }
    }
}
