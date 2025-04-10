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

    public function update(TimeSlot $timeSlot, array $data)
    {
        $timeSlot->update($data);

        return $timeSlot;
    }

    public function delete(TimeSlot $timeSlot)
    {
        return $timeSlot->delete();
    }
}
