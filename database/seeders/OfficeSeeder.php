<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 5; $i++) {
            Office::factory()->create([
                'name' => 'Consulta '.$i,
                'abbreviation' => 'C'.$i,
            ]);
        }

        for ($i = 1; $i < 4; $i++) {
            Office::factory()->create([
                'name' => 'Polivalente '.$i,
                'abbreviation' => 'P'.$i,
            ]);
        }

        Office::factory()->create([
            'name' => 'Evaluación Avanzada',
            'abbreviation' => 'EA',
        ]);

        Office::factory()->create([
            'name' => 'Contactología',
            'abbreviation' => 'CO',
        ]);

    }
}
