<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 20; $i++) {
            Patient::factory()->create([
                'email' => 'patient'.$i.'@example.com',
                'name' => 'Patient '.$i,
                'surnames' => 'Surname '.$i,
                'phone' => '11122233'.$i,
                'dni' => '12345678F'.$i,
            ]);
        }
    }
}
