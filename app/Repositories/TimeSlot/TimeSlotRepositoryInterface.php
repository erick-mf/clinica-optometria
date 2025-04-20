<?php

namespace App\Repositories\TimeSlot;

use App\Models\TimeSlot;

interface TimeSlotRepositoryInterface
{
    public function paginate(int $perPage = 10);

    public function all();

    public function find(int $id);

    public function create(array $data);

    public function update($timeSlotId, array $data);

    public function delete(TimeSlot $timeSlot);

    public function isAvailable($timeSlotId);

    public function reserveTimeSlot($timeSlotId);
}
