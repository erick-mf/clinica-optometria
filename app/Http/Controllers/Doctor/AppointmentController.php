<?php

namespace App\Http\Controllers\Doctor;

use App\Events\AppointmentCreated;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Repositories\Appointment\AppointmentRepositoryInterface;
use App\Repositories\AvailableDate\AvailableDateRepositoryInterface;
use App\Repositories\Patient\PatientRepositoryInterface;
use App\Repositories\TimeSlot\TimeSlotRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    public function __construct(
        private readonly AppointmentRepositoryInterface $appoinmentRepository,
        private readonly PatientRepositoryInterface $patientRepository,
        private readonly TimeSlotRepositoryInterface $timeSlotRepository,
        private readonly AvailableDateRepositoryInterface $availableDateRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener las citas del doctor autenticado con paginación
        $appointments = $this->appoinmentRepository->paginateByDoctor(Auth::user()->id);

        return view('doctor.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Patient $patient)
    {
        $patient_id = $patient->id;
        $doctor = Auth::user()->id;
        $schedules = $this->timeSlotRepository->all();
        $availableSlots = $this->availableDateRepository->getAvailableDatesWithSlots();

        return view('doctor.appointments.create', compact('patient_id', 'doctor', 'schedules', 'availableSlots'));
    }

    // Mostrar detalles de la cita
    public function show(Appointment $appointment)
    {
        return view('show-details', compact('appointment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|exists:time_slots,id',
            'type' => 'required|in:primera cita,revision',
            'details' => 'nullable|string|max:255',
        ], [
            'patient_id.required' => 'El paciente es obligatorio.',
            'patient_id.exists' => 'El paciente seleccionado no existe.',
            'user_id.required' => 'El doctor es obligatorio.',
            'appointment_date.required' => 'La fecha de la cita es obligatoria.',
            'appointment_time.required' => 'El horario es obligatorio.',
            'appointment_time.exists' => 'El horario seleccionado no existe.',
            'type.required' => 'El tipo de cita es obligatorio.',
            'type.in' => 'El tipo de cita debe ser "primera cita" o "revisión".',
            'details.max' => 'Los detalles no pueden exceder los 255 caracteres.',
        ]);
        $validated['time_slot_id'] = $validated['appointment_time'];
        $patient = $this->patientRepository->findById($validated['patient_id']);

        // Verificar si el paciente ya tiene una cita agendada
        $alreadyHasAppointment = $this->appoinmentRepository->isAlreadyBooked($patient->id, $validated['appointment_date']);
        if ($alreadyHasAppointment === true) {
            return back()->with('toast', ['type' => 'info', 'message' => 'Ya tiene una cita agendada ese día.'])->withInput();
        }

        $slot = $this->timeSlotRepository->isAvailable($validated['appointment_time']);
        if (! $slot) {
            return back()->with('toast', ['type' => 'info', 'message' => 'La hora seleccionada no está disponible.'])->withInput();
        }

        try {
            DB::beginTransaction();
            $appointment = $this->appoinmentRepository->create($validated);

            // Enviar correo de confirmación
            $timeSlot = $this->timeSlotRepository->find($validated['appointment_time']);
            event(new AppointmentCreated($appointment, $patient, $timeSlot, $validated['appointment_date']));

            DB::commit();

            // Redirigir con un mensaje de éxito
            return redirect()->route('patients.index')->with('toast', ['type' => 'success', 'message' => 'Cita creada correctamente.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al crear la cita: {$e->getMessage()}");

            return back()->with('toast', ['type' => 'error', 'message' => 'Error al crear la cita.'])->withInput();
        }
    }
}
