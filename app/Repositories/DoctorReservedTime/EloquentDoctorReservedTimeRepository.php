<?php

namespace App\Repositories\DoctorReservedTime;

use App\Models\DoctorReservedTime;
use Illuminate\Support\Facades\DB;

class EloquentDoctorReservedTimeRepository implements DoctorReservedTimeRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private DoctorReservedTime $model) {}

    public function paginate(int $perPage, int $userId)
    {
        return $this->model->query()->where('user_id', $userId)->orderBy('date', 'asc')->paginate($perPage);
    }

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(DoctorReservedTime $doctorReservedTime, array $data)
    {
        $doctorReservedTime->update($data);
        $doctorReservedTime->save();

        return $doctorReservedTime;
    }

    public function delete(int $id)
    {
        return DB::transaction(function () use ($id) {
            $this->model->where('id', $id)->delete();
        });
    }
}
