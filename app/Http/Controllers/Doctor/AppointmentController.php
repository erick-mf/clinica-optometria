<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Schedule;
use App\Repositories\Appointment\AppointmentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    private AppointmentRepositoryInterface $repository;

    public function __construct(AppointmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener las citas del doctor autenticado con paginación
        $appointments = auth()->user()->appointments()->paginate(10);

        return view('doctor.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::all();
        $doctor = Auth::user()->id;
        $schedules = Schedule::all();

        return view('doctor.appointments.create', compact('patients', 'doctor', 'schedules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'schedule_id' => 'required|exists:schedules,id',
            'type' => 'required|in:primera cita,revision',
            'details' => 'nullable|string|max:255',
        ], [
            'patient_id.required' => 'El paciente es obligatorio.',
            'patient_id.exists' => 'El paciente seleccionado no existe.',
            'schedule_id.required' => 'El horario es obligatorio.',
            'schedule_id.exists' => 'El horario seleccionado no existe.',
            'type.required' => 'El tipo de cita es obligatorio.',
            'type.in' => 'El tipo de cita debe ser "primera cita" o "revisión".',
            'details.max' => 'Los detalles no pueden exceder los 255 caracteres.',
        ]);

        // Verificar si el horario ya está ocupado por otra cita
        $existingAppointment = $this->repository->create($validated);

        if ($existingAppointment) {
            return redirect()->back()
                ->withErrors(['schedule_id' => 'El horario seleccionado ya está ocupado.'])
                ->withInput();
        }

        // Redirigir con un mensaje de éxito
        return redirect()->route('doctor.appointments.index')->with('success', 'Cita creada correctamente.');
    }

    // Mostrar detalles de la cita
    public function show(Appointment $appointment)
    {
        return view('show-details', compact('appointment'));
    }
}
