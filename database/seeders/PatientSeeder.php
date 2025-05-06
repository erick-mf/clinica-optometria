<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;

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
                'phone' => '11122233'.$i,
                'dni' => '12345678F'.$i,
            ]);
        }
    }
}
