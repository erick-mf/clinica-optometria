<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'surnames' => fake()->name(),
            'birthdate' => fake()->date(),
            'phone' => '111222333',
            'email' => fake()->unique()->safeEmail(),
            'dni' => fake()->unique()->numberBetween(10000000, 99999999),
            'birthdate' => fake()->date(),
        ];
    }
}
