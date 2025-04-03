<?php

namespace App\Repositories\Doctor;

use App\Models\User;

class EloquentDoctorRepository implements DoctorRepositoryInterface
{
    private User $model;

    public function __construct()
    {
        $this->model = new User;
    }

    public function paginate(int $perPage = 10)
    {
        return $this->model->query()->where('role', 'doctor')->orderBy('id', 'desc')->paginate($perPage);
    }

    public function searchPaginate(string $search, int $perPage = 10)
    {
        return $this->model->query()
            ->where('role', 'doctor')
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('surnames', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        $data['role'] = 'doctor';

        return $this->model->create($data);
    }

    public function update(User $user, array $data)
    {
        $user->update($data);

        return $user;
    }

    public function delete(User $user)
    {
        return $user->delete();
    }
}
