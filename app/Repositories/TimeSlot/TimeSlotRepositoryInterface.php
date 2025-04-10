<?php

namespace App\Repositories\TimeSlot;

use App\Models\TimeSlot;

interface TimeSlotRepositoryInterface
{
    public function paginate(int $perPage = 10);

    public function all();

    public function find(int $id);

    public function create(array $data);

    public function update(TimeSlot $timeSlot, array $data);

    public function delete(TimeSlot $timeSlot);
}
