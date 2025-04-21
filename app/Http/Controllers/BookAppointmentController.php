<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookAppointmentRequest;
use App\Repositories\Appointment\AppointmentRepositoryInterface;
use App\Repositories\AvailableDate\AvailableDateRepositoryInterface;
use App\Repositories\Doctor\DoctorRepositoryInterface;
use App\Repositories\Patient\PatientRepositoryInterface;
use App\Repositories\TimeSlot\TimeSlotRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
        $alreadyHasAppointment = $this->appointmentRepository->isAlreadyBooked($patient->id, $validated['appointment_date']);
        if ($alreadyHasAppointment === true) {
            return back()->with('toast', ['type' => 'info', 'message' => 'Ya tiene una cita agendada ese día.'])->withInput();
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

            // Obtenemos la información completa del time_slot
            $timeSlot = $this->timeSlotRepository->find($validated['appointment_time']);

            $dateAppointment = $validated['appointment_date'];

            $this->sendAppointmentEmail($patient, $appointment, $timeSlot, $dateAppointment);
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

    public function sendAppointmentEmail($patient, $appointment, $timeSlot, $dateAppointment)
    {
        $age = date_diff(date_create($patient->birthdate), date_create('now'))->y;
        if ($age >= 18) {
            Mail::send('email.appointment-email', [
                'patient' => $patient,
                'appointment' => $appointment,
                'time_slot' => $timeSlot,
                'date_appointment' => $dateAppointment,
            ], function ($message) use ($patient) {
                $message->to($patient->email, $patient->name.' '.$patient->surnames)
                    ->subject('Confirmación de su cita - Clínica Universitaria de Visión y Optometría');
            });
        } else {
            Mail::send('email.appointment-email-child', [
                'patient' => $patient,
                'appointment' => $appointment,
                'time_slot' => $timeSlot,
                'date_appointment' => $dateAppointment,
            ], function ($message) use ($patient) {
                $message->to($patient->tutor_email, $patient->tutor_name)
                    ->subject('Confirmación de su cita - Clínica Universitaria de Visión y Optometría');
            });
        }
    }
}
