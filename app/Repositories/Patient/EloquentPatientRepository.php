<?php

namespace App\Repositories\Patient;

use App\Models\Patient;

class EloquentPatientRepository implements PatientRepositoryInterface
{
    private Patient $model;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->model = new Patient;
    }

    public function paginate(int $perPage = 10)
    {
        return $this->model->query()->orderBy('id', 'desc')->paginate($perPage);
    }

    public function searchPaginate(string $search, int $perPage = 10)
    {
        return $this->model->query()
            ->where('name', 'like', '%'.$search.'%')
            ->orWhere('surnames', 'like', '%'.$search.'%')
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Patient $user, array $data)
    {
        $user->update($data);

        return $user;
    }

    public function delete(Patient $user)
    {
        return $user->delete();
    }
}
