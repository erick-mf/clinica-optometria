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
        $doctorsQuery = $this->model->query()->orderBy('id', 'desc');

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
        return $this->model->get();
    }

    public function create(array $data)
    {
        $data['name'] = ucwords(strtolower($data['name']));
        $data['surnames'] = ucwords(strtolower($data['surnames']));
        $data['email'] = strtolower($data['email']);

        return $this->model->create($data);
    }

    public function update(User $user, array $data)
    {
        $data['name'] = ucwords(strtolower($data['name']));
        $data['surnames'] = ucwords(strtolower($data['surnames']));
        $data['email'] = strtolower($data['email']);

        $user->update($data);

        return $user;
    }

    public function delete(User $user)
    {
        if ($_ENV['ADMIN_EMAIL'] == $user->email) {
            return [
                'error' => 'No se puede eliminar a este profesional.', ];
        }

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

    public function getDoctorsWithOffices()
    {
        return $this->model
            ->where('role', 'doctor')
            ->whereHas('office')
            ->get();
    }
}
