<?php

namespace App\Repositories\AvailableDate;

use App\Models\AvailableDate;

interface AvailableDateRepositoryInterface
{
    public function paginate(int $perPage = 10);

    public function all();

    public function allWithHoursAndSlotsPaginate(int $perPage = 10);

    public function find($id);

    public function create(array $data);

    public function update(AvailableDate $availableDate, array $data);

    public function delete(int $id);

    public function deleteAll();

    public function getNextDate();
}
