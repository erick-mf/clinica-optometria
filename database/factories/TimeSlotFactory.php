<?php

namespace Database\Factories;

use App\Models\AvailableHour;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimeSlot>
 */
class TimeSlotFactory extends Factory
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
            'available_hour_id' => $this->faker->randomElement(AvailableHour::all())->id,
        ];
    }
}
