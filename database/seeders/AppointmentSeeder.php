<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Detail;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();
        $schedules = Schedule::all();
        $doctors = User::where('role', 'doctor')->get();

        if ($patients->isEmpty() || $schedules->isEmpty() || $doctors->isEmpty()) {
            $this->command->info('No hay suficientes datos.');
            return;
        }

        foreach ($patients as $patient) {
            Appointment::factory()->create([
                'patient_id' => $patient->id,
                'schedule_id' => $schedules->random()->id,
                'doctor_id' => $doctors->random()->id,
                'type' => fake()->randomElement(['normal', 'revision']),
                'details' => fake()->text(200),
            ]);
        }
    }
}
