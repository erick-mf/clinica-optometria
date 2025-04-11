<?php

namespace App\Repositories\Patient;

use App\Models\Patient;

interface PatientRepositoryInterface
{
    public function paginate(int $perPage = 10);

    public function searchPaginate(string $search, int $perPage = 10);

    public function all();

    public function find($dni);

    public function create(array $data);

    public function update(Patient $user, array $data);

    public function delete(Patient $user);

    public function count();
}
