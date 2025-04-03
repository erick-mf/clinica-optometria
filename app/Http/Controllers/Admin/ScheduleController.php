<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Repositories\Schedule\ScheduleRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function __construct(private readonly ScheduleRepositoryInterface $repository) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = $this->repository->paginate();

        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'date' => 'required|date|date_format:Y-m-d',
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Verificar si existe conflicto con otros horarios
        $existingSchedule = Schedule::where('date', $request->date)
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('start_time', '<=', $request->start_time)
                        ->where('end_time', '>', $request->start_time);
                })->orWhere(function ($q) use ($request) {
                    $q->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>=', $request->end_time);
                })->orWhere(function ($q) use ($request) {
                    $q->where('start_time', '>=', $request->start_time)
                        ->where('end_time', '<=', $request->end_time);
                });
            })->first();

        if ($existingSchedule) {
            return back()->with('error', 'Ya existe un horario que se superpone con el seleccionado. Por favor elige otro horario.');
        }

        // Crear el horario
        $schedule = new Schedule;
        $schedule->day = $request->day;
        $schedule->date = $request->date;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->save();

        return redirect()->route('schedules.index')
            ->with('success', 'Horario guardado correctamente para el '.
                   Carbon::parse($request->date)->format('d/m/Y').' de '.
                   Carbon::parse($request->start_time)->format('H:i').' a '.
                   Carbon::parse($request->end_time)->format('H:i'));
    }

    public function getSchedules()
    {
        $schedules = Schedule::all();
        $events = [];

        foreach ($schedules as $schedule) {
            $events[] = [
                'title' => Carbon::parse($schedule->start_time)->format('H:i').' - '.
                          Carbon::parse($schedule->end_time)->format('H:i'),
                'start' => $schedule->date.'T'.$schedule->start_time,
                'end' => $schedule->date.'T'.$schedule->end_time,
            ];
        }

        return response()->json($events);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $this->repository->delete($schedule);

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Horario eliminado correctamente.');
    }
}
