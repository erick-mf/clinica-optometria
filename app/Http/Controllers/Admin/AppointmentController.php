<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Repositories\Appointment\AppointmentRepositoryInterface;
use App\Repositories\AvailableDate\AvailableDateRepositoryInterface;
use App\Repositories\Doctor\DoctorRepositoryInterface;
use App\Repositories\Patient\PatientRepositoryInterface;
use App\Repositories\TimeSlot\TimeSlotRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    /**
     * Constructor: Inyecta el repositorio de citas.
     */
    public function __construct(
        private readonly DoctorRepositoryInterface $doctorRepository,
        private readonly AppointmentRepositoryInterface $appoinmentRepository,
        private readonly PatientRepositoryInterface $patientRepository,
        private readonly TimeSlotRepositoryInterface $timeSlotRepository,
        private readonly AvailableDateRepositoryInterface $availableDateRepository
    ) {}

    /**
     * Muestra una lista de citas con paginación y búsqueda.
     */
    public function index()
    {
        $appointments = $this->appoinmentRepository->paginate();

        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * Muestra el formulario para crear una nueva cita.
     */
    public function create(Patient $patient)
    {
        $patient = $patient->id;
        $schedules = $this->timeSlotRepository->all();
        $doctors = $this->doctorRepository->getDoctorWithSchedule();
        $availableSlots = $this->availableDateRepository->getAvailableDatesWithSlots();

        return view('admin.appointments.create', compact('patient', 'schedules', 'doctors', 'availableSlots'));
    }

    /**
     * Muestra todos los detalles de una cita.
     */
    public function show(Appointment $appointment)
    {
        return view('show-details', compact('appointment'));
    }

    /**
     * Almacena una nueva cita en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|exists:time_slots,id',
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:primera cita,revision',
            'details' => 'nullable|string|max:255',
        ], [
            'appointment_date.required' => 'La fecha es obligatoria.',
            'patient_id.required' => 'El paciente es obligatorio.',
            'appointment_time.required' => 'El horario es obligatorio.',
            'user_id.required' => 'El doctor es obligatorio.',
            'type.required' => 'El tipo es obligatorio.',
        ]);

        $this->appoinmentRepository->create($validated);
        $validated['time_slot_id'] = $validated['appointment_time'];
        $slot = $this->appoinmentRepository->isAlreadyBooked($validated['patient_id'], $validated['appointment_date']);
        if ($slot === true) {
            return back()->with('toast', ['type' => 'info', 'message' => 'El paciente ya tiene una cita agendada ese día.'])->withInput();
        }

        try {
            $this->appoinmentRepository->create($validated);

            return redirect()
                ->route('admin.patients.index')
                ->with('toast', ['type' => 'success', 'message' => 'Cita creada correctamente.']);
        } catch (Exception $e) {
            Log::error('Error al crear la cita: '.$e->getMessage());

            return back()
                ->withInput()
                ->with('toast', ['type' => 'error', 'message' => 'Error al crear la cita. Por favor intente nuevamente.'])->withInput();
        }
    }

    // NOTE: Es necesario este metodo?
    /**
     * Muestra el formulario para editar una cita existente.
     */
    public function edit(Appointment $appointment)
    {
        $patient = $appointment->patiend_id;
        $schedules = $this->timeSlotRepository->all();
        $doctors = $this->doctorRepository->all();
        $availableSlots = $this->availableDateRepository->getAvailableDatesWithSlots();

        return view('admin.appointments.edit', compact('patient', 'schedules', 'doctors', 'availableSlots', 'appointment'));
    }

    // NOTE: Es necesario este metodo?
    /**
     * Actualiza una cita existente en la base de datos.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'time_slot_id' => 'required|exists:time_slots,id',
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:primera cita,revision',
            'details' => 'nullable|string|max:255',
        ]);

        $this->appoinmentRepository->update($appointment, $validated);

        return redirect()
            ->route('admin.appointments.index')
            ->with('toast', ['type' => 'success', 'message' => 'Cita actualizada correctamente.']);
    }

    /**
     * Elimina una cita de la base de datos.
     */
    public function destroy(Appointment $appointment)
    {
        try {
            $this->appoinmentRepository->delete($appointment);

            return redirect()
                ->route('admin.appointments.index')
                ->with('toast', ['type' => 'success', 'message' => 'Cita eliminada correctamente.']);
        } catch (Exception $e) {
            Log::error('Error al eliminar la cita: '.$e->getMessage());

            return back()
                ->with('toast', ['type' => 'error', 'message' => 'Error al eliminar la cita. Por favor intente nuevamente.']);
        }
    }
}
