<?php

namespace App\Http\Controllers;

use App\Repositories\Appointment\AppointmentRepositoryInterface;
use App\Repositories\AvailableDate\AvailableDateRepositoryInterface;
use App\Repositories\Patient\PatientRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BookAppointmentController extends Controller
{
    public function __construct(
        private readonly AvailableDateRepositoryInterface $availableDateRepository,
        private readonly AppointmentRepositoryInterface $appointmentRepository,
        private readonly PatientRepositoryInterface $patientRepository
    ) {}

    public function index()
    {
        // Obtener fechas disponibles con formato correcto
        $availableDates = $this->availableDateRepository->getAvailableDatesWithSlots();

        return view('book-appointment', [
            'availableSlots' => $availableDates,
        ]);
    }

    public function getAvailableSlots(string $date)
    {
        // Obtener slots disponibles para la fecha solicitada
        $slots = $this->availableDateRepository->getAvailableSlotsForDate($date);

        return response()->json($slots);
    }

    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $validator = $request->validate([
            'name' => 'required|string|regex:/^[A-Za-z\s]+$/|max:255',
            'surnames' => 'required|string|regex:/^[A-Za-z\s]+$/|max:255',
            'birthdate' => 'required|date',
            'email' => 'required|email|max:255',
            'phone' => 'required|digits:9|regex:/^[6-9]\d{8}$/',
            'dni' => 'required|max:9|regex:/^[XYZ]?\d{7,8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i',
            'type' => 'required|in:primera cita,revision',
            'appointment_date' => 'required|date_format:Y-m-d',
            'appointment_time' => 'required|integer|exists:time_slots,id',
            'details' => 'nullable|string|regex:/^[A-Za-z\s]+$/|max:255',
            'privacy-policy' => 'required|accepted',
        ], [
            'name.required' => 'El campo de nombre es obligatorio.',
            'name.string' => 'El campo de nombre debe ser una cadena de texto.',
            'name.regex' => 'El campo de nombre solo puede contener letras y espacios.',
            'surnames.required' => 'El campo de apellidos es obligatorio.',
            'surnames.string' => 'El campo de apellidos debe ser una cadena de texto.',
            'surnames.regex' => 'El campo de apellidos solo puede contener letras y espacios.',
            'birthdate.required' => 'El campo de fecha de nacimiento es obligatorio.',
            'email.required' => 'El campo de correo electr&oacute;nico es obligatorio.',
            'phone.required' => 'El campo del teléfono es obligatorio.',
            'phone.digits' => 'El campo de teléfono debe tener 9 dígitos.',
            'phone.regex' => 'El campo de teléfono debe tener un formato valido.',
            'dni.required' => 'El campo de DNI es obligatorio.',
            'dni.max' => 'El campo de DNI no puede tener m&aacute;s de 9 caracteres.',
            'dni.regex' => 'El campo de DNI debe tener un formato v&aacute;lido.',
            'type.required' => 'El campo de tipo de cita es obligatorio.',
            'type.in' => 'El campo de tipo de cita debe ser "Primera cita" o "Revisión".',
            'appointment_date.required' => 'El campo de fecha de la cita es obligatorio.',
            'appointment_time.required' => 'El campo de hora de la cita es obligatorio.',
            'details.string' => 'El campo de detalles debe ser una cadena de texto.',
            'details.regex' => 'El campo de detalles solo puede contener letras y espacios.',
            'privacy-policy.required' => 'Debes aceptar la pol&iacute;tica de privacidad.',
            'privacy-policy.accepted' => 'Debes aceptar la pol&iacute;tica de privacidad.',
        ]);

        $patient = $this->patientRepository->find($request->dni);

        if (! $patient) {
            $patient = $this->patientRepository->create([
                'name' => $request->name,
                'surnames' => $request->surnames,
                'phone' => $request->phone,
                'email' => $request->email,
                'dni' => $request->dni,
                'birthdate' => $request->birthdate,
            ]);
        }

        try {
            DB::beginTransaction();

            // Verificar disponibilidad del slot
            $slot = DB::table('time_slots')
                ->where('id', $request->appointment_time)
                ->where('is_available', true)
                ->first();

            if (! $slot) {
                return redirect()->back()->with('toast', ['type' => 'error', 'message' => 'El slot seleccionado no està; disponible.'])->withInput();
            }

            // Marcar el slot como reservado
            $this->availableDateRepository->reserveTimeSlot($request->appointment_time);

            // Crear la cita
            $appointment = $this->appointmentRepository->create([
                'type' => $request->type,
                'details' => $request->details,
                'user_id' => 2,
                'patient_id' => $patient->id,
                'time_slot_id' => $request->appointment_time,
            ]);

            // Obtenemos la información completa del time_slot
            $timeSlot = DB::table('time_slots')->where('id', $request->appointment_time)->first();

            $dateAppointment = $request->appointment_date;

            $this->sendAppointmentEmail($patient, $appointment, $timeSlot, $dateAppointment);
            DB::commit();

            return redirect()->route('home')->with('toast', ['type' => 'success', 'message' => 'Cita reservada correctamente.']);
        } catch (\Exception $e) {
            DB::rollBack(); // Esto revierte todas las operaciones de BD, incluyendo la reserva del slot

            return redirect()->back()->with('toast', ['type' => 'error', 'message' => 'Error al reservar la cita.'])->withInput();
        }
    }

    public function sendAppointmentEmail($patient, $appointment, $timeSlot, $dateAppointment)
    {
        // Enviar el correo
        Mail::send('email.appointment-email', [
            'patient' => $patient,
            'appointment' => $appointment,
            'time_slot' => $timeSlot,
            'date_appointment' => $dateAppointment,
        ], function ($message) use ($patient) {
            $message->to($patient->email, $patient->name.' '.$patient->surnames)
                ->subject('Confirmación de su cita - Clínica Universitaria de Visión y Optometría');
        });
    }
}
