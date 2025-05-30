<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Office>
 */
class OfficeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'abbreviation' => $this->faker->randomLetter(),
            'status' => $this->faker->randomElement(['activo']),
            'user_id' => $this->faker->randomElement(User::all())->id,
        ];
    }
}
