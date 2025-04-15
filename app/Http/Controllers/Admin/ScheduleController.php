<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AvailableDate\AvailableDateRepositoryInterface;
use App\Repositories\AvailableHour\AvailableHourRepositoryInterface;
use App\Repositories\TimeSlot\TimeSlotRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function __construct(
        private readonly AvailableDateRepositoryInterface $availableDateRepository,
        private readonly AvailableHourRepositoryInterface $availableHourRepository,
        private readonly TimeSlotRepositoryInterface $timeSlotRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nextDate = null;
        $schedules = $this->availableDateRepository->allWithHoursAndSlotsPaginate(10);
        $dateCarbon = $this->availableDateRepository->getNextDate();
        if (! $dateCarbon) {
            $nextDate = 'N/A';
        } else {
            $nextDate = Carbon::parse($dateCarbon->date)->format('d/m/Y');
        }

        return view('admin.schedules.index', compact('schedules', 'nextDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener las fechas que ya están configuradas para deshabilitarlas en el datepicker
        $existingDates = $this->availableDateRepository->all()->pluck('date')->toArray();
        $disabledDates = array_map(function ($date) {
            return Carbon::parse($date)->format('Y-m-d');
        }, $existingDates);

        return view('admin.schedules.create', compact('disabledDates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'days' => 'required|array',
            'days.*' => 'integer|min:0|max:6',
            'interval_minutes' => 'required|integer|min:1',
            'turns' => 'required|array',
            'turns.*.start' => 'required|date_format:H:i',
            'turns.*.end' => 'required|date_format:H:i|after:turns.*.start',
        ]);

        try {
            DB::beginTransaction();

            $startDate = Carbon::parse($validated['start_date']);
            $endDate = Carbon::parse($validated['end_date']);
            $selectedDays = $validated['days'];
            $intervalMinutes = (int) $validated['interval_minutes']; // Asegurarse que sea entero
            $turns = $validated['turns'];

            // Iterar desde la fecha inicial hasta la final
            $currentDate = clone $startDate;
            while ($currentDate->lte($endDate)) {
                // Verificar si es uno de los días seleccionados
                if (in_array($currentDate->dayOfWeek, $selectedDays)) {

                    // Crear fecha disponible
                    $availableDate = $this->availableDateRepository->create([
                        'date' => $currentDate->format('Y-m-d'),
                    ]);

                    if ($availableDate) {
                        // Procesar cada turno
                        foreach ($turns as $turn) {
                            // Crear objetos Carbon para las horas solo hora, sin fecha
                            $startTime = Carbon::createFromFormat('H:i', $turn['start']);
                            $endTime = Carbon::createFromFormat('H:i', $turn['end']);

                            // Crear el horario disponible
                            $availableHour = $this->availableHourRepository->create([
                                'available_date_id' => $availableDate->id,
                                'start_time' => $startTime->format('H:i'),
                                'end_time' => $endTime->format('H:i'),
                            ]);

                            if ($availableHour) {
                                // Generar slots de tiempo
                                $slotStart = clone $startTime;
                                $slotNumber = 1;

                                while ($slotStart->lt($endTime)) {
                                    // Calcular la hora de fin del slot
                                    $slotEnd = (clone $slotStart)->addMinutes($intervalMinutes);

                                    // Si el slot termina después del fin del turno, ajustarlo
                                    if ($slotEnd->gt($endTime)) {
                                        $slotEnd = clone $endTime;
                                    }

                                    // Crear el slot solo si hay un intervalo válido
                                    if ($slotStart->lt($slotEnd)) {
                                        $timeSlot = $this->timeSlotRepository->create([
                                            'available_hour_id' => $availableHour->id,
                                            'start_time' => $slotStart->format('H:i'),
                                            'end_time' => $slotEnd->format('H:i'),
                                            'slot_number' => $slotNumber,
                                            'available' => true,
                                        ]);
                                    }

                                    // Avanzar al siguiente intervalo
                                    $slotStart = clone $slotEnd;
                                }
                            }
                        }
                    }
                }

                // Avanzar al siguiente día
                $currentDate->addDay();
            }

            DB::commit();

            return redirect()->route('admin.schedules.index')
                ->with('toast', ['type' => 'success', 'message' => 'Horario creado correctamente.']);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->withErrors(['error' => 'Error: '.$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     $schedule = $this->availableDateRepository->findWithHoursAndSlots($id);
    //     if (! $schedule) {
    //         return redirect()->route('admin.schedules.index')->with('error', 'Horario no encontrado');
    //     }
    //
    //     return view('admin.schedules.show', compact('schedule'));
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $schedule = $this->availableDateRepository->findWithHoursAndSlots($id);
        if (! $schedule) {
            return redirect()->route('admin.schedules.index')->with('error', 'Horario no encontrado');
        }

        return view('admin.schedules.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'turns' => 'required|array',
            'turns.*.id' => 'sometimes|integer|exists:available_hours,id',
            'turns.*.start' => 'required|date_format:H:i',
            'turns.*.end' => 'required|date_format:H:i|after:turns.*.start',
            'interval_minutes' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $schedule = $this->availableDateRepository->find($id);
            if (! $schedule) {
                return redirect()->route('admin.schedules.index')->with('toast', ['type' => 'error', 'message' => 'Horario no encontrado']);
            }

            $intervalMinutes = $validated['interval_minutes'];
            $turns = $validated['turns'];

            // Actualizar o crear horarios disponibles
            foreach ($turns as $turn) {
                $startTime = Carbon::parse($turn['start']);
                $endTime = Carbon::parse($turn['end']);

                // Si hay ID, actualizar, si no, crear nuevo
                if (isset($turn['id'])) {
                    $availableHour = $this->availableHourRepository->update($turn['id'], [
                        'start_time' => $startTime->format('H:i'),
                        'end_time' => $endTime->format('H:i'),
                    ]);

                    // Eliminar slots existentes y crear nuevos
                    $this->timeSlotRepository->deleteByHourId($availableHour->id);
                } else {
                    $availableHour = $this->availableHourRepository->create([
                        'available_date_id' => $schedule->id,
                        'start_time' => $startTime->format('H:i'),
                        'end_time' => $endTime->format('H:i'),
                    ]);
                }

                // Generar los slots de tiempo según el intervalo
                $currentTime = clone $startTime;
                $slotNumber = 1;

                while ($currentTime->lt($endTime)) {
                    $slotEndTime = (clone $currentTime)->addMinutes($intervalMinutes);

                    // Si el final del slot excede el fin del turno, ajustamos
                    if ($slotEndTime->gt($endTime)) {
                        $slotEndTime = clone $endTime;
                    }

                    // Solo crear el slot si hay un intervalo de tiempo válido
                    if ($currentTime->lt($slotEndTime)) {
                        $this->timeSlotRepository->create([
                            'available_hour_id' => $availableHour->id,
                            'start_time' => $currentTime->format('H:i'),
                            'end_time' => $slotEndTime->format('H:i'),
                            'slot_number' => $slotNumber,
                            'available' => true,
                        ]);

                        $slotNumber++;
                    }

                    // Avanzar al siguiente intervalo
                    $currentTime = $slotEndTime;
                }
            }

            DB::commit();

            return redirect()->route('admin.schedules.index')->with('toast', ['type' => 'success', 'message' => 'Horario actualizado correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->withErrors('toast', ['type' => 'error', 'message' => 'Error al actualizar el horario']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->availableDateRepository->delete((int) $id);

            return redirect()->route('admin.schedules.index')->with('toast', ['type' => 'success', 'message' => 'Horario eliminado correctamente']);
        } catch (\Exception $e) {

            return redirect()->route('admin.schedules.index')->with('toast', ['type' => 'error', 'message' => 'Error al eliminar el horario']);
        }
    }

    public function destroyAll()
    {
        try {
            $this->availableDateRepository->deleteAll();

            return redirect()->route('admin.schedules.index')->with('success', 'Todos los horarios han sido eliminados');
        } catch (\Exception $e) {

            return redirect()->route('admin.schedules.index')->with('error', 'Error al eliminar todos los horarios');
        }
    }
}
