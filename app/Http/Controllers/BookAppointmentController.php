<?php

namespace App\Http\Controllers;

use App\Events\AppointmentCreated;
use App\Http\Requests\BookAppointmentRequest;
use App\Repositories\Appointment\AppointmentRepositoryInterface;
use App\Repositories\AvailableDate\AvailableDateRepositoryInterface;
use App\Repositories\Doctor\DoctorRepositoryInterface;
use App\Repositories\Patient\PatientRepositoryInterface;
use App\Repositories\TimeSlot\TimeSlotRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookAppointmentController extends Controller
{
    public function __construct(
        private readonly AvailableDateRepositoryInterface $availableDateRepository,
        private readonly AppointmentRepositoryInterface $appointmentRepository,
        private readonly PatientRepositoryInterface $patientRepository,
        private readonly DoctorRepositoryInterface $doctorRepository,
        private readonly TimeSlotRepositoryInterface $timeSlotRepository
    ) {}

    public function index()
    {
        // Obtener fechas disponibles con formato correcto
        $availableDates = $this->availableDateRepository->getAvailableDatesWithSlots();
        // Obtener doctores disponibles
        $availableDoctors = $this->doctorRepository->getDoctorWithSchedule();

        if ($availableDoctors->isEmpty()) {
            return redirect()->route('home')->with('toast', ['type' => 'info', 'message' => 'No hay citas disponibles']);
        }

        return view('book-appointment', [
            'availableSlots' => $availableDates,
        ]);
    }

    public function getAvailableSlots(string $date)
    {
        try {
            // Obtener slots disponibles para la fecha solicitada
            $slots = $this->availableDateRepository->getAvailableSlotsForDate($date);

            return response()->json($slots);
        } catch (\Exception $e) {
            Log::error('Error al obtener los slots disponibles: '.$e);

            return response()->json(['error' => 'Error al obtener los slots disponibles.']);
        }
    }

    public function store(BookAppointmentRequest $request)
    {
        $validated = $request->validated();
        $patient = $this->patientRepository->findByIdentity($validated);

        if (! $patient) {
            $patient = $this->patientRepository->create($validated);
        }

        // Verificar si el paciente ya tiene una cita agendada
        $alreadyHasAppointment = $this->appointmentRepository->isAlreadyBooked($patient->id, false);
        if ($alreadyHasAppointment) {
            return back()->with('toast', [
                'type' => 'info',
                'message' => 'Ya tiene una cita agendada pendiente.No puede agendar otra hasta que complete o cancele esta cita'])->withInput();
        }

        // Verificar disponibilidad del slot
        $slot = $this->timeSlotRepository->isAvailable($validated['appointment_time']);
        if (! $slot) {
            return back()->with('toast', ['type' => 'info', 'message' => 'La hora seleccionada no está disponible.'])->withInput();
        }

        try {
            DB::beginTransaction();
            // Crear la cita
            $validated['time_slot_id'] = $validated['appointment_time'];
            $validated['patient_id'] = $patient->id;
            $validated['user_id'] = $this->lastAssignedDoctorId();
            $appointment = $this->appointmentRepository->create($validated);

            // Enviar correo de confirmación
            $timeSlot = $this->timeSlotRepository->find($validated['appointment_time']);

            // Verificar si hay un correo disponible antes de enviar el evento
            if (!empty($patient->email) || !empty($patient->tutor_email)) {
                event(new AppointmentCreated($appointment, $patient, $timeSlot, $validated['appointment_date']));
            } 

            DB::commit();

            return redirect()->route('home')->with('toast', ['type' => 'success', 'message' => 'Cita reservada correctamente.']);
        } catch (\Exception $e) {
            DB::rollBack(); // Esto revierte todas las operaciones de BD, incluyendo la reserva del slot
            Log::error('Error al reservar la cita: '.$e);

            return back()->with('toast', ['type' => 'error', 'message' => 'Error al reservar la cita.'])->withInput();
        }
    }

    public function lastAssignedDoctorId()
    {
        $availableDoctors = $this->doctorRepository->getDoctorWithSchedule();

        $lastAssignedDoctorId = Cache::get('last_assigned_doctor_id');

        // Seleccionar el siguiente doctor
        if (! $lastAssignedDoctorId) {
            $assignedDoctor = $availableDoctors->first();
        } else {
            $nextIndex = $availableDoctors->search(function ($doctor) use ($lastAssignedDoctorId) {
                return $doctor->id > $lastAssignedDoctorId;
            });

            $assignedDoctor = $nextIndex !== false
                ? $availableDoctors[$nextIndex]
                : $availableDoctors->first();
        }

        // Guardar el último doctor asignado
        Cache::put('last_assigned_doctor_id', $assignedDoctor->id);

        return $assignedDoctor->id;
    }

    public function showCancel($token)
    {
        $appointment = $this->appointmentRepository->findByToken($token);

        if (! $appointment) {
            return redirect()->route('home')->with('toast', ['type' => 'error', 'message' => 'Cita no encontrada.']);
        }

        return view('cancel-appointment', compact('appointment'));
    }

    public function cancel($token)
    {
        $appointment = $this->appointmentRepository->findByToken($token);

        if (! $appointment) {
            return redirect()->route('home')->with('toast', ['type' => 'error', 'message' => 'Cita no encontrada.']);
        }

        try {
            $this->appointmentRepository->delete($appointment);

            return redirect()->route('home')->with('toast', ['type' => 'success', 'message' => 'Cita cancelada correctamente.']);
        } catch (\Exception $e) {
            Log::error('Error al cancelar la cita: '.$e);

            return back()->with('toast', ['type' => 'error', 'message' => 'Error al cancelar la cita.']);
        }
    }
}
