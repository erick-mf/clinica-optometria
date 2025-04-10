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
        return $this->model->with([
            'patient',
            'user',
            'timeSlot.availableHour.availableDate',
        ])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function searchPaginate(string $search, int $perPage = 10)
    {
        return $this->model->query()
            ->where(function ($query) use ($search) {
                $query->whereHas('patient', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('surnames', 'like', '%'.$search.'%');
                })
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', '%'.$search.'%')
                            ->orWhere('surnames', 'like', '%'.$search.'%');
                    });
            })
            ->with(['patient', 'user', 'timeSlot.availableHour.availableDate'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function appointmentTodayPaginated($perPage = 15)
    {
        return $this->model->query()->whereHas('timeSlot.availableHour.availableDate', function ($query) {
            $query->where('date', '>=', now()->format('Y-m-d'));
        })
            ->with(['patient', 'user', 'timeSlot'])
            ->orderBy('created_at', 'asc')
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

        return $appointment;
    }

    public function delete(Appointment $appointment)
    {
        TimeSlot::where('id', $appointment->time_slot_id)->update(['is_available' => true]);

        return $appointment->delete();
    }
}
