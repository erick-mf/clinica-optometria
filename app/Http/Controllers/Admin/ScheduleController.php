<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AvailableDate\AvailableDateRepositoryInterface;
use App\Repositories\Doctor\DoctorRepositoryInterface;
use App\Services\ScheduleService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    public function __construct(
        private readonly AvailableDateRepositoryInterface $availableDateRepository,
        private readonly DoctorRepositoryInterface $doctorRepository,
        private readonly ScheduleService $scheduleService
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
        $doctors = $this->doctorRepository->all();

        return view('admin.schedules.index', compact('schedules', 'nextDate', 'doctors'));
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
        $doctors = $this->doctorRepository->all();

        return view('admin.schedules.create', compact('disabledDates', 'doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'days' => 'required|array',
            'days.*' => 'integer|min:0|max:6',
            'interval_minutes' => 'required|integer|min:1',
            'turns' => 'required|array',
            'turns.*.start' => 'required|date_format:H:i',
            'turns.*.end' => 'required|date_format:H:i|after:turns.*.start',
            'turns.*.doctors' => 'required|array|min:1',
            'turns.*.doctors.*' => 'exists:users,id',
        ]);

        $result = $this->scheduleService->createSchedule($validated);

        if ($result['success']) {
            return redirect()->route('admin.schedules.index')
                ->with('toast', [
                    'type' => 'success',
                    'message' => $result['message'],
                ]);
        }

        return back()->withInput()
            ->with('toast', [
                'type' => 'error',
                'message' => $result['message'],
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->availableDateRepository->delete((int) $id);

            return redirect()->route('admin.schedules.index')
                ->with('toast', ['type' => 'success', 'message' => 'Horario eliminado correctamente']);
        } catch (\Exception $e) {
            Log::error("Error al eliminar el horario: {$e->getMessage()}");

            return back()
                ->with('toast', ['type' => 'error', 'message' => 'Error al eliminar el horario']);
        }
    }

    public function destroyAll()
    {
        try {
            $this->availableDateRepository->deleteAll();

            return redirect()->route('admin.schedules.index')
                ->with('toast', ['type' => 'success', 'message' => 'Todos los horarios eliminados correctamente']);
        } catch (\Exception $e) {
            Log::error("Error al eliminar todos los horarios: {$e->getMessage()}");

            return back()
                ->with('toast', ['type' => 'error', 'message' => 'Error al eliminar todos los horarios']);
        }
    }
}
