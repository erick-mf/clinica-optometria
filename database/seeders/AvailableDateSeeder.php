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
        AvailableDate::factory()->count(30)->create();
    }
}
