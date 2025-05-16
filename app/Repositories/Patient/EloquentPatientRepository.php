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
        return $this->model->query()->where('document_number', $dni)->first();
    }

    public function findById($id)
    {
        return $this->model->query()->where('id', $id)->first();
    }

    public function findByIdentity($data)
    {
        return $this->model->query()
            ->when(
                isset($data['document_number']),
                function ($query) use ($data) {
                    $query->where('document_number', $data['document_number']);
                },
                function ($query) use ($data) {
                    $query->where('name', $data['name'])
                        ->where('surnames', $data['surnames'])
                        ->whereDate('birthdate', $data['birthdate'])
                        ->where('tutor_document_number', $data['tutor_document_number']);
                })
            ->first();
    }

    public function create(array $data)
    {
        if ($this->findByIdentity($data)) {
            return false;
        }

        return $this->model->create([
            'name' => ucwords(strtolower($data['name'])),
            'surnames' => ucwords(strtolower($data['surnames'])),
            'phone' => $data['phone'],
            'email' => isset($data['email']) ? strtolower($data['email']) : null,
            'document_type' => isset($data['document_type']) ? $data['document_type'] : null,
            'document_number' => isset($data['document_number']) ? strtoupper($data['document_number']) : null,
            'birthdate' => $data['birthdate'],
            'tutor_name' => isset($data['tutor_name']) ? ucwords(strtolower($data['tutor_name'])) : null,
            'tutor_email' => isset($data['tutor_email']) ? strtolower($data['tutor_email']) : null,
            'tutor_document_type' => isset($data['tutor_document_type']) ? $data['tutor_document_type'] : null,
            'tutor_document_number' => isset($data['tutor_document_number']) ? $data['tutor_document_number'] : null,
            'tutor_phone' => $data['tutor_phone'],
        ]);
    }

    public function update(Patient $user, array $data)
    {
        if ($this->findByIdentity($data)) {
            return false;
        }

        $user->update([
            'name' => ucwords(strtolower($data['name'])),
            'surnames' => ucwords(strtolower($data['surnames'])),
            'phone' => $data['phone'],
            'email' => isset($data['email']) ? strtolower($data['email']) : null,
            'document_type' => isset($data['document_type']) ? $data['document_type'] : null,
            'document_number' => isset($data['document_number']) ? isset($data['document_number']) : null,
            'birthdate' => $data['birthdate'],
            'tutor_name' => isset($data['tutor_name']) ? ucwords(strtolower($data['tutor_name'])) : null,
            'tutor_email' => isset($data['tutor_email']) ? strtolower($data['tutor_email']) : null,
            'tutor_document_type' => isset($data['tutor_document_type']) ? $data['tutor_document_type'] : null,
            'tutor_document_number' => isset($data['tutor_document_number']) ? isset($data['tutor_document_number']) : null,
            'tutor_phone' => $data['tutor_phone'],
        ]);

        return $user;
    }

    public function delete(Patient $user)
    {
        return $user->delete();
    }
}
