<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Map Spanish days to English
        $dayMapping = [
            'Lunes' => 'Monday',
            'Martes' => 'Tuesday',
            'Miércoles' => 'Wednesday',
            'Jueves' => 'Thursday',
            'Viernes' => 'Friday',
        ];

        // Get a random day in Spanish
        $dayOfWeek = $this->faker->randomElement(array_keys($dayMapping));

        // Get the corresponding English day
        $englishDay = $dayMapping[$dayOfWeek];

        // Set Carbon locale to Spanish for display purposes
        Carbon::setLocale('es');

        // Get the current date and calculate the next occurrence of the given day of the week
        $nextDay = Carbon::now()->next($englishDay); // This gives us the next occurrence of that day

        return [
            'day' => $dayOfWeek,  // Store the Spanish day name
            'date' => $nextDay->toDateString(),  // Store the specific date for that day
            'start_time' => $this->faker->time('H:i', '08:00'),
            'end_time' => $this->faker->time('H:i', '17:00'),
        ];
    }
}
