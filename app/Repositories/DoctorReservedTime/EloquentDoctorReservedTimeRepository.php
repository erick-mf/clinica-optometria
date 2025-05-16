<?php

namespace App\Repositories\DoctorReservedTime;

use App\Models\DoctorReservedTime;
use App\Repositories\AvailableHour\AvailableHourRepositoryInterface;
use Illuminate\Support\Facades\DB;

class EloquentDoctorReservedTimeRepository implements DoctorReservedTimeRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private DoctorReservedTime $model,
        private readonly AvailableHourRepositoryInterface $availableHourRepository,
    ) {}

    public function paginate(int $perPage, int $userId)
    {
        return $this->model->query()->where('user_id', $userId)->orderBy('date', 'asc')->paginate($perPage);
    }

    public function paginateAll(int $perPage)
    {
        return $this->model->query()->with('doctor')->orderBy('date', 'asc')->paginate($perPage);
    }

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function getReservedTimesByDate($date, $officeId = null)
    {
        $availableHours = $this->availableHourRepository->getAvailableHoursByDate($date);

        $reservedTimes = $this->model->where('date', $date)->where('office_id', $officeId)->get(['start_time', 'end_time']);

        return collect($availableHours)->merge($reservedTimes);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            if (! isset($data['office_id'])) {
                throw new \Exception('El campo office_id es obligatorio para crear una reserva');
            }

            // Validar solapamiento con otras reservas en la misma oficina
            $conflictWithOffice = $this->model
                ->where('date', $data['date'])
                ->where('office_id', $data['office_id'])
                ->where(function ($query) use ($data) {
                    $query->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                        ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']])
                        ->orWhere(function ($q) use ($data) {
                            $q->where('start_time', '<=', $data['start_time'])
                                ->where('end_time', '>=', $data['end_time']);
                        });
                })
                ->exists();

            if ($conflictWithOffice) {
                throw new \Exception('El horario seleccionado se solapa con otra reserva en esta oficina');
            }

            // Validar solapamiento con sus propias reservas en cualquier oficina (opcional)
            $conflictWithSelf = $this->model
                ->where('date', $data['date'])
                ->where('user_id', $data['user_id'])
                ->where(function ($query) use ($data) {
                    $query->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                        ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']])
                        ->orWhere(function ($q) use ($data) {
                            $q->where('start_time', '<=', $data['start_time'])
                                ->where('end_time', '>=', $data['end_time']);
                        });
                })
                ->exists();

            if ($conflictWithSelf) {
                throw new \Exception('El doctor ya tiene una reserva personal en ese horario');
            }

            // Validar contra horarios disponibles para pacientes USANDO EL REPOSITORIO
            $conflictWithAvailable = $this->availableHourRepository
                ->checkAvailabilityConflict(
                    $data['office_id'],
                    $data['date'],
                    $data['start_time'],
                    $data['end_time']
                );

            if ($conflictWithAvailable) {
                throw new \Exception('El horario colisiona con un horario disponible para pacientes');
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
