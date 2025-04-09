<?php

namespace App\Repositories\AvailableDate;

use App\Models\AvailableDate;

class EloquentAvailableDateRepository implements AvailableDateRepositoryInterface
{
    private AvailableDate $model;

    public function __construct()
    {
        $this->model = new AvailableDate;
    }

    public function paginate(int $perPage = 10)
    {
        $query = $this->model->query()->orderBy('id', 'desc');

        if ($query->count() == 0) {
            return collect();
        }

        $currentPage = (int) request()->get('page', 1);
        if ($currentPage < 1) {
            $currentPage = 1;
        }

        $paginator = $query->paginate($perPage);
        if ($currentPage > $paginator->lastPage() && $paginator->lastPage() > 0) {
            return $query->paginate($perPage, ['*'], 'page', $paginator->lastPage());
        }

        return $paginator;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(AvailableDate $availableDate, array $data)
    {
        $availableDate->update($data);

        return $availableDate;
    }

    public function delete(AvailableDate $availableDate)
    {
        return $availableDate->delete();
    }
}
