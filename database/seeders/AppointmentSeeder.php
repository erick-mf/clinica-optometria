<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();
        $doctors = User::where('role', 'doctor')->get();

        if ($patients->isEmpty() || $doctors->isEmpty()) {
            $this->command->info('No hay suficientes datos.');

            return;
        }

        foreach ($patients as $patient) {
            Appointment::factory()->create([
                'patient_id' => $patient->id,
                'user_id' => $doctors->random()->id,
                'type' => fake()->randomElement(['normal', 'revision']),
                'details' => fake()->text(200),
            ]);
        }
    }
}
