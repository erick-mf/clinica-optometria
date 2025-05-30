<?php

namespace App\Repositories\DoctorReservedTime;

use App\Models\DoctorReservedTime;

interface DoctorReservedTimeRepositoryInterface
{
    public function paginate(int $perPage, int $userId);

    public function paginateAll(int $perPage);

    public function findById(int $id);

    public function getReservedTimesByDate($date, $officeId = null);

    public function all();

    public function create(array $data);

    public function update(DoctorReservedTime $doctorReservedTime, array $data);

    public function delete(int $id);
}
