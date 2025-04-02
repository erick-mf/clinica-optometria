<?php

namespace App\Repositories\Schedule;

use App\Models\Schedule;

interface ScheduleRepositoryInterface
{
    public function paginate(int $perPage = 10);

    public function find($id);

    public function create(array $data);

    public function update(Schedule $schedule, array $data);

    public function delete(Schedule $schedule);
}
