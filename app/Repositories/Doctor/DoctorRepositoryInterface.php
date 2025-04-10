<?php

namespace App\Repositories\Doctor;

use App\Models\User;

interface DoctorRepositoryInterface
{
    public function paginate(int $perPage = 10);

    public function all();

    public function find($id);

    public function create(array $data);

    public function update(User $user, array $data);

    public function delete(User $user);

    public function count();
}
