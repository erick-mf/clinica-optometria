<?php

namespace App\Repositories\AvailableHour;

use App\Models\AvailableHour;

interface AvailableHourRepositoryInterface
{
    public function paginate(int $perPage = 10);

    public function find(int $id);

    public function create(array $data);

    public function update(AvailableHour $availableHour, array $data);

    public function delete(AvailableHour $availableHour);
}
