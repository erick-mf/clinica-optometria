<?php

namespace App\Listeners;

use App\Events\AppointmentCreated;
use Illuminate\Support\Facades\Mail;

class SendAppointmentEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AppointmentCreated $event): void
    {
        $patient = $event->patient;
        $appointment = $event->appointment;
        $time_slot = $event->timeSlot;
        $date_appointment = $event->dateAppointment;
        $cancel_url = url(route('appointments.cancel', [
            'token' => $appointment->token,
        ], false));

        $age = date_diff(date_create($patient->birthdate), date_create('now'))->y;
        if ($age >= 18) {
            Mail::send('email.appointment-email', compact(
                'patient', 'appointment', 'time_slot', 'date_appointment', 'cancel_url'
            ), function ($message) use ($patient) {
                $message->to($patient->email, $patient->name.' '.$patient->surnames)
                    ->subject('Confirmación de su cita - Clínica Universitaria de Visión y Optometría');
            });
        } else {
            Mail::send('email.appointment-email-child', compact(
                'patient', 'appointment', 'time_slot', 'date_appointment', 'cancel_url'
            ), function ($message) use ($patient) {
                $message->to($patient->tutor_email, $patient->tutor_name)
                    ->subject('Confirmación de su cita - Clínica Universitaria de Visión y Optometría');
            });
        }
    }
}
