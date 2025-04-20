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
        $doctorsQuery = $this->model->query()->where('role', 'doctor')->orderBy('id', 'desc');

        // Si no hay doctores, devolver colección vacía
        if ($doctorsQuery->count() == 0) {
            return collect();
        }

        // Obtener y validar el número de página
        $currentPage = (int) request()->get('page', 1);

        // Asegurarse que la página no sea menor a 1
        if ($currentPage < 1) {
            $currentPage = 1;
        }

        // Crear el paginador inicial
        $paginator = $doctorsQuery->paginate($perPage);

        // Si la página solicitada es mayor que la última página disponible
        if ($currentPage > $paginator->lastPage()) {
            // Crear un nuevo paginador con la última página
            return $doctorsQuery->paginate($perPage, ['*'], 'page', $paginator->lastPage());
        }

        return $paginator;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function all()
    {
        return $this->model->where('role', 'doctor')->get();
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

    public function getScheduleByDoctor($id)
    {
        // Agrupa los horarios por fecha
        return $this->model->where('role', 'doctor')->with('hours.availableDate')->findOrFail($id)->hours->groupBy(function ($hour) {
            return $hour->availableDate->date;
        });
    }

    public function getDoctorWithSchedule()
    {
        return $this->model
            ->where('role', 'doctor')
            ->whereHas('availableHours') // Solo doctores que tengan horas configuradas
            ->get();
    }
}
