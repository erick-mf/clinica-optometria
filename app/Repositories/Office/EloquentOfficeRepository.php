<?php

namespace App\Repositories\Office;

use App\Models\Office;
use Illuminate\Support\Facades\DB;

class EloquentOfficeRepository implements OfficeRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private Office $model) {}

    public function all()
    {
        return $this->model->orderBy('name')->get();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        $data['name'] = ucwords(strtolower($data['name']));

        return $this->model->create($data);
    }

    public function update(Office $office, array $data)
    {
        $data['name'] = ucwords(strtolower($data['name']));

        $office->update($data);

        return $office;
    }

    public function delete(Office $office)
    {
        return DB::transaction(function () use ($office) {
            $office->delete();
        });
    }
}
