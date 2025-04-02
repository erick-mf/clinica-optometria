<?php

namespace App\Repositories\Schedule;

use App\Models\Schedule;

class EloquentScheduleRepository implements ScheduleRepositoryInterface
{
    private Schedule $model;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->model = new Schedule;
    }

    public function paginate(int $perPage = 10)
    {
        return $this->model->orderBy('day', 'desc')->paginate($perPage);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Schedule $schedule, array $data)
    {
        $schedule->update($data);

        return $schedule;
    }

    public function delete(Schedule $schedule)
    {
        return $schedule->delete();
    }
}
