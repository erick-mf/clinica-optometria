<?php

namespace App\Http\Controllers\Admin;

use App\Events\AppointmentCreated;
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
use Illuminate\Support\Facades\DB;
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

            return redirect()->route('admin.patients.index')->with('toast', ['type' => 'success', 'message' => 'Cita creada correctamente.']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error al crear la cita: '.$e->getMessage());

            return back()->withInput()->with('toast', ['type' => 'error', 'message' => 'Error al crear la cita. Por favor intente nuevamente.'])->withInput();
        }
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
