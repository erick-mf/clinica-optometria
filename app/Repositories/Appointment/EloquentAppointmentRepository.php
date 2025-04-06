<?php

namespace App\Repositories\Appointment;

use Illuminate\Support\Facades\App;
use App\Models\Appointment;
use App\Repositories\Appointment\AppointmentRepositoryInterface;

class EloquentAppointmentRepository implements AppointmentRepositoryInterface
{
    protected Appointment $model;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->model = new Appointment;
    }

    public function paginate(int $perPage = 10)
    {
        return $this->model->query()
        ->with(['patient', 'doctor', 'schedule']) 
        ->orderBy('id', 'desc')
        ->paginate($perPage);
    }

    public function searchPaginate(string $search, int $perPage = 10)
    {
        return $this->model->query()
        ->whereHas('patient', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('surnames', 'like', '%' . $search . '%');
        })
        ->with(['patient', 'doctor', 'schedule']) 
        ->orderBy('id', 'desc')
        ->paginate($perPage);
    }

    public function find($id)
    {
        return $this->model->find(['patient', 'doctor', 'schedule'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Appointment $appointment, array $data)
    {
        $appointment->update($data);

        return $appointment;
    }

    public function delete(Appointment $appointment)
    {
        return $appointment->delete();
    }
}
