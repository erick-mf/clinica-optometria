<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\User;
use App\Repositories\Appointment\AppointmentRepositoryInterface;
use App\Repositories\Doctor\DoctorRepositoryInterface;
use App\Repositories\Patient\PatientRepositoryInterface;
use App\Repositories\TimeSlot\TimeSlotRepositoryInterface;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Constructor: Inyecta el repositorio de citas.
     */
    public function __construct(
        private readonly AppointmentRepositoryInterface $appoinmentRepository,
        private readonly DoctorRepositoryInterface $doctorRepository,
        private readonly PatientRepositoryInterface $patientRepository,
        private readonly TimeSlotRepositoryInterface $timeSlotRepository
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
    public function create()
    {
        $patients = $this->patientRepository->all();
        $timeSlots = $this->timeSlotRepository->all();
        $doctors = $this->doctorRepository->all();

        return view('admin.appointments.create', compact('patients', 'timeSlots', 'doctors'));
    }

    /**
     * Muestra todos los detalles de una cita.
     */
    public function show(Appointment $appointment)
    {
        return view('ShowDetails', compact('appointment'));
    }

    /**
     * Almacena una nueva cita en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'time_slot_id' => 'required|exists:time_slots,id',
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:normal,revision',
            'details' => 'nullable|string|max:255',
        ], [
            'patient_id.required' => 'El paciente es obligatorio.',
            'time_slot_id.required' => 'El horario es obligatorio.',
            'user_id.required' => 'El doctor es obligatorio.',
            'type.required' => 'El tipo es obligatorio.',
        ]);

        $this->appoinmentRepository->create($validated);

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Cita creada correctamente.');
    }

    /**
     * Muestra el formulario para editar una cita existente.
     */
    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();
        $schedules = Schedule::all();
        $doctors = User::where('role', 'doctor')->get();

        return view('admin.appointments.edit', compact('appointment', 'patients', 'schedules', 'doctors'));
    }

    /**
     * Actualiza una cita existente en la base de datos.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'schedule_id' => 'required|exists:schedules,id',
            'doctor_id' => 'required|exists:users,id',
            'type' => 'required|in:normal,revision',
            'details' => 'nullable|string|max:255',
        ]);

        $this->appoinmentRepository->update($appointment, $validated);

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Cita actualizada correctamente.');
    }

    /**
     * Elimina una cita de la base de datos.
     */
    public function destroy(Appointment $appointment)
    {
        $this->appoinmentRepository->delete($appointment);
        session()->flash('success', 'Cita eliminada correctamente.');

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Cita eliminada correctamente.');
    }
}
