<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['primera cita', 'revision']),
            'details' => $this->faker->sentence(),
            'user_id' => $this->faker->randomElement(User::all())->id,
            'patient_id' => $this->faker->randomElement(Patient::all())->id,
            'time_slot_id' => $this->faker->randomElement(TimeSlot::all())->id,
        ];
    }
}
