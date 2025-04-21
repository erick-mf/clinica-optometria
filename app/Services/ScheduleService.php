<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleService
{
    public function createSchedule(array $validatedData)
    {
        DB::beginTransaction();

        try {
            $startDate = Carbon::parse($validatedData['start_date']);
            $endDate = Carbon::parse($validatedData['end_date']);
            $selectedDays = $validatedData['days'];
            $intervalMinutes = (int) $validatedData['interval_minutes'];
            $turns = $validatedData['turns'];

            // Paso 1: Procesar fechas
            $availableDates = $this->processDates($startDate, $endDate, $selectedDays);

            // Paso 2: Procesar horarios
            $availableHours = $this->processAvailableHours($availableDates, $turns);

            // Paso 3: Procesar doctores y slots
            $this->processDoctorsAndSlots($availableHours, $turns, $intervalMinutes);

            DB::commit();

            return [
                'success' => true,
                'days_created' => count($availableDates),
                'message' => 'Horarios creados exitosamente para '.count($availableDates).' días.',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en ScheduleService: '.$e->getMessage());

            return [
                'success' => false,
                'message' => 'Error al crear los horarios: '.$e->getMessage(),
            ];
        }
    }

    protected function processDates(Carbon $startDate, Carbon $endDate, array $selectedDays)
    {
        // Generar fechas necesarias
        $datesToCreate = [];
        $currentDate = clone $startDate;

        while ($currentDate->lte($endDate)) {
            if (in_array($currentDate->dayOfWeek, $selectedDays)) {
                $datesToCreate[] = $currentDate->format('Y-m-d');
            }
            $currentDate->addDay();
        }

        // Evitar duplicados
        $existingDates = DB::table('available_dates')
            ->whereIn('date', $datesToCreate)
            ->pluck('date')
            ->toArray();

        $newDates = array_diff($datesToCreate, $existingDates);

        // Insertar nuevas fechas
        $availableDatesToInsert = array_map(function ($date) {
            return [
                'date' => $date,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $newDates);

        if (! empty($availableDatesToInsert)) {
            DB::table('available_dates')->insert($availableDatesToInsert);
        }

        // Obtener IDs de todas las fechas relevantes
        return DB::table('available_dates')
            ->whereIn('date', $datesToCreate)
            ->pluck('id', 'date');
    }

    protected function processAvailableHours($availableDates, $turns)
    {
        $availableHoursToInsert = [];

        foreach ($availableDates as $dateString => $availableDateId) {
            foreach ($turns as $turn) {
                $startTime = Carbon::createFromFormat('H:i', $turn['start']);
                $endTime = Carbon::createFromFormat('H:i', $turn['end']);

                $availableHoursToInsert[] = [
                    'start_time' => $startTime->format('H:i'),
                    'end_time' => $endTime->format('H:i'),
                    'is_available' => true,
                    'available_date_id' => $availableDateId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (! empty($availableHoursToInsert)) {
            DB::table('available_hours')->insert($availableHoursToInsert);
        }

        return DB::table('available_hours')
            ->whereIn('available_date_id', $availableDates->values())
            ->orderBy('id')
            ->get()
            ->groupBy('available_date_id');
    }

    protected function processDoctorsAndSlots($availableHours, $turns, $intervalMinutes)
    {
        $doctorAvailableHoursToInsert = [];
        $timeSlotsToInsert = [];

        foreach ($availableHours as $availableDateId => $dateTurns) {
            $turnIndex = 0;

            foreach ($dateTurns as $availableHour) {
                $turn = $turns[$turnIndex % count($turns)];
                $turnIndex++;

                // Obtener los doctores disponibles para este horario
                $doctorsInTurn = $turn['doctors'];

                // Procesar cada doctor en el turno
                foreach (array_unique($doctorsInTurn) as $doctorId) {
                    // Insertar la relación doctor-available_hour (evitando duplicados)
                    $doctorAvailableHoursToInsert[] = [
                        'doctor_id' => $doctorId,
                        'available_hour_id' => $availableHour->id,
                    ];

                    // Generar slots de tiempo PARA CADA DOCTOR disponible en este horario
                    $startTime = Carbon::createFromFormat('H:i', $availableHour->start_time);
                    $endTime = Carbon::createFromFormat('H:i', $availableHour->end_time);
                    $slotStart = clone $startTime;

                    while ($slotStart->lt($endTime)) {
                        $slotEnd = (clone $slotStart)->addMinutes($intervalMinutes);
                        if ($slotEnd->gt($endTime)) {
                            $slotEnd = clone $endTime;
                        }

                        if ($slotStart->lt($slotEnd)) {
                            $timeSlotsToInsert[] = [
                                'start_time' => $slotStart->format('H:i'),
                                'end_time' => $slotEnd->format('H:i'),
                                'is_available' => true,
                                'available_hour_id' => $availableHour->id,
                            ];
                        }
                        $slotStart = clone $slotEnd;
                    }
                }
            }
        }

        // Insertar relaciones doctor-horario (evitando duplicados)
        $uniqueDoctorAvailableHours = collect($doctorAvailableHoursToInsert)->unique(function ($item) {
            return $item['doctor_id'].'-'.$item['available_hour_id'];
        })->toArray();

        if (! empty($uniqueDoctorAvailableHours)) {
            DB::table('doctor_available_hours')->insert($uniqueDoctorAvailableHours);
        }

        // Insertar slots de tiempo
        if (! empty($timeSlotsToInsert)) {
            DB::table('time_slots')->insert($timeSlotsToInsert);
        }
    }
}
