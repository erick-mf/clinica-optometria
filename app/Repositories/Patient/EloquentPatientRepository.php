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

    public function all()
    {
        return $this->model->all();
    }

    public function search(string $search)
    {
        $query = $this->model->query();

        // Buscar solo por DNI
        if (preg_match('/^[XYZ\d]\d{7,8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i', $search)) {
            return $query->where('dni', strtoupper($search))
                ->orderBy('id', 'desc')
                ->paginate();
        }

        // Buscar en nombre y apellidos
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
                ->orWhere('surnames', 'like', "%$search%");
        })
            ->orderBy('id', 'desc')
            ->paginate();
    }

    public function find($dni)
    {
        return $this->model->query()->where('dni', $dni)->first();
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

    public function count()
    {
        return $this->model->query()->count();
    }
}
