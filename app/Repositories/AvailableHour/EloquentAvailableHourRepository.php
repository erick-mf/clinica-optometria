<?php

namespace App\Repositories\AvailableHour;

use App\Models\AvailableHour;

class EloquentAvailableHourRepository implements AvailableHourRepositoryInterface
{
    private AvailableHour $model;

    public function __construct()
    {
        $this->model = new AvailableHour;
    }

    public function paginate(int $perPage = 10)
    {
        $query = $this->model->query()->orderBy('id', 'desc');

        if ($query->count() == 0) {
            return collect();
        }

        $currentPage = (int) request()->get('page', 1);
        if ($currentPage < 1) {
            $currentPage = 1;
        }

        $paginator = $query->paginate($perPage);
        if ($currentPage > $paginator->lastPage() && $paginator->lastPage() > 0) {
            return $query->paginate($perPage, ['*'], 'page', $paginator->lastPage());
        }

        return $paginator;
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(AvailableHour $availableHour, array $data)
    {
        $availableHour->update($data);

        return $availableHour;
    }

    public function delete(AvailableHour $availableHour)
    {
        return $availableHour->delete();
    }

    public function getAvailableHoursByDate($date)
    {
        return $this->model->whereHas('availableDate', function ($query) use ($date) {
            $query->where('date', $date);
        })->get(['start_time', 'end_time']);
    }

    public function checkAvailabilityConflict($officeId, $date, $startTime, $endTime)
    {
        return $this->model->whereHas('availableDate', function ($q) use ($date) {
            $q->where('date', $date);
        })
            ->where('office_id', $officeId)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->exists();
    }
}
