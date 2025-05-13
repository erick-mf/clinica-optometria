<?php

namespace App\Repositories\DoctorReservedTime;

use App\Models\AvailableHour;
use App\Models\DoctorReservedTime;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\DB;

class EloquentDoctorReservedTimeRepository implements DoctorReservedTimeRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private DoctorReservedTime $model,
        private AvailableHour $availableHour,
        private TimeSlot $timeSlot
    ) {}

    public function paginate(int $perPage, int $userId)
    {
        return $this->model->query()->where('user_id', $userId)->orderBy('date', 'asc')->paginate($perPage);
    }

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Verificar si ya existe una reserva en ese horario
            $conflict = $this->model->where('date', $data['date'])
                ->where(function ($query) use ($data) {
                    $query->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                        ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']])
                        ->orWhere(function ($q) use ($data) {
                            $q->where('start_time', '<=', $data['start_time'])
                                ->where('end_time', '>=', $data['end_time']);
                        });
                })->exists();

            if ($conflict) {
                throw new \Exception('El horario seleccionado se solapa con una reserva existente');
            }

            return $this->model->create($data);
        });
    }

    public function update(DoctorReservedTime $doctorReservedTime, array $data)
    {
        $doctorReservedTime->update($data);
        $doctorReservedTime->save();

        return $doctorReservedTime;
    }

    public function delete(int $id)
    {
        return DB::transaction(function () use ($id) {
            $this->model->where('id', $id)->delete();
        });
    }
}
