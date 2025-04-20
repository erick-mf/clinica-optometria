<?php

namespace Database\Factories;

use App\Models\AvailableHour;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DoctorAvailableHour>
 */
class DoctorAvailableHourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'doctor_id' => $this->faker->randomElement(User::all())->id,
            'available_hour_id' => $this->faker->randomElement(AvailableHour::all())->id,
        ];
    }
}
