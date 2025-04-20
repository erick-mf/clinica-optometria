<?php

namespace App\Repositories\TimeSlot;

use App\Models\TimeSlot;

class EloquentTimeSlotRepository implements TimeSlotRepositoryInterface
{
    private TimeSlot $model;

    public function __construct()
    {
        $this->model = new TimeSlot;
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

    public function all()
    {
        return $this->model->query()->where('is_available', 1)->get();
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($timeSlotId, array $data)
    {
        $timeSlot = $this->find($timeSlotId);

        return $timeSlot->update($data);
    }

    public function delete(TimeSlot $timeSlot)
    {
        return $timeSlot->delete();
    }

    public function isAvailable($timeSlotId)
    {
        return $this->model->query()->where('id', $timeSlotId)->where('is_available', 1)->first();
    }

    public function reserveTimeSlot($timeSlotId)
    {
        return $this->model->query()->where('id', $timeSlotId)->where('is_available', 1)->update(['is_available' => 0]);
    }
}
