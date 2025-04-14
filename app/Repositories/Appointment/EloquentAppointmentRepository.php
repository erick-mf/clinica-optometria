<?php

namespace App\Repositories\Appointment;

use App\Models\Appointment;
use App\Models\TimeSlot;

class EloquentAppointmentRepository implements AppointmentRepositoryInterface
{
    protected Appointment $model;

    public function __construct()
    {
        $this->model = new Appointment;
    }

    public function paginate(int $perPage = 10)
    {
        return $this->model->query()
            ->with([
                'patient',
                'user',
                'timeSlot.availableHour.availableDate', // Carga las relaciones necesarias
            ])
            ->select('appointments.*')
            ->join('time_slots', 'appointments.time_slot_id', '=', 'time_slots.id')
            ->join('available_hours', 'time_slots.available_hour_id', '=', 'available_hours.id')
            ->join('available_dates', 'available_hours.available_date_id', '=', 'available_dates.id')
            ->orderBy('available_dates.date', 'asc') // Orden principal por fecha
            ->orderBy('time_slots.start_time', 'asc') // Orden secundario por hora
            ->paginate($perPage);
    }

    public function appointmentTodayPaginated($perPage = 10)
    {
        return $this->model->query()
            ->whereHas('timeSlot.availableHour.availableDate', function ($query) {
                $query->where('date', '>=', now()->format('Y-m-d')); // Citas desde hoy en adelante
            })
            ->with([
                'patient',
                'user',
                'timeSlot.availableHour.availableDate', // Carga las relaciones necesarias
            ])
            ->select('appointments.*') // Asegura que seleccionamos solo campos de appointments
            ->join('time_slots', 'appointments.time_slot_id', '=', 'time_slots.id')
            ->join('available_hours', 'time_slots.available_hour_id', '=', 'available_hours.id')
            ->join('available_dates', 'available_hours.available_date_id', '=', 'available_dates.id')
            ->orderByRaw("
            CASE
                WHEN available_dates.date = DATE('now') THEN 0
                ELSE 1
            END
        ")
            ->orderBy('available_dates.date', 'asc')
            ->orderBy('time_slots.start_time', 'asc')
            ->paginate($perPage);
    }

    public function find($id)
    {
        return $this->model->with(['patient', 'user', 'timeSlot'])->findOrFail($id);
    }

    public function create(array $data)
    {
        $appointment = $this->model->create($data);

        TimeSlot::where('id', $data['time_slot_id'])
            ->where('is_available', true)
            ->update(['is_available' => false]);

        return $appointment;
    }

    public function update(Appointment $appointment, array $data)
    {
        // Si se cambia el time_slot_id, debemos actualizar el estado de disponibilidad
        if (isset($data['time_slot_id']) && $data['time_slot_id'] != $appointment->time_slot_id) {
            // Liberar el slot anterior
            TimeSlot::where('id', $appointment->time_slot_id)->update(['is_available' => true]);

            // Ocupar el nuevo slot
            TimeSlot::where('id', $data['time_slot_id'])
                ->where('is_available', true)
                ->update(['is_available' => false]);
        }

        $appointment->update($data);
        $appointment->save();

        return $appointment;
    }

    public function delete(Appointment $appointment)
    {
        TimeSlot::where('id', $appointment->time_slot_id)->update(['is_available' => true]);

        return $appointment->delete();
    }
}
