<?php

namespace Database\Factories;

use App\Models\AvailableDate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AvailableHour>
 */
class AvailableHourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_time' => fake()->time('H:i'),
            'end_time' => fake()->time('H:i'),
            'is_available' => fake()->boolean(),
            'available_date_id' => $this->faker->randomElement(AvailableDate::all())->id,
        ];
    }
}
