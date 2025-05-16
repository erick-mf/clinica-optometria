<?php

namespace App\Repositories\AvailableDate;

use App\Models\AvailableDate;
use Illuminate\Support\Facades\DB;

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

    public function all()
    {
        return $this->model->all();
    }

    public function allWithHoursAndSlotsPaginate(int $perPage = 10)
    {
        $query = $this->model->with('hours.timeSlots')->orderBy('date', 'asc');

        return $query->paginate($perPage);

    }

    public function allWithHoursAndSlotsByDoctorPaginate(int $doctorId, int $perPage = 10)
    {
        $query = $this->model->with('hours.timeSlots')->where('doctor_id', $doctorId)->orderBy('date', 'asc');

        return $query->paginate($perPage);
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

    public function delete(int $id)
    {
        $date = $this->model->find($id);
        if (! $date) {
            return false;
        }

        return $date->delete();
    }

    public function deleteAll()
    {
        return $this->model->query()->truncate();
    }

    public function getNextDate()
    {
        return $this->model->query()->where('date', '>', now())->orderBy('date', 'asc')->first();
    }

    public function getAvailableDatesWithSlots()
    {
        $availableSlots = DB::table('available_dates as ad')
            ->join('available_hours as ah', 'ad.id', '=', 'ah.available_date_id')
            ->join('time_slots as ts', 'ah.id', '=', 'ts.available_hour_id')
            ->where('ts.is_available', true)
            ->where('ah.is_available', true)
            ->where('ad.date', '>=', now()->format('Y-m-d'))
            ->select('ad.date', 'ts.id', 'ts.start_time', 'ts.end_time', 'ts.is_available')
            ->get();

        $formattedSlots = [];
        foreach ($availableSlots as $slot) {
            $date = $slot->date;
            if (! isset($formattedSlots[$date])) {
                $formattedSlots[$date] = [];
            }

            $formattedSlots[$date][] = [
                'id' => $slot->id,
                'start_time' => $slot->start_time,
                'end_time' => $slot->end_time,
                'available' => (bool) $slot->is_available,
            ];
        }

        return $formattedSlots;
    }

    public function getAvailableSlotsForDate(string $date)
    {
        $dateRecord = $this->model
            ->where('date', $date)
            ->with(['hours.timeSlots' => function ($query) {
                $query->where('is_available', true);
            }])
            ->first();

        if (! $dateRecord) {
            return collect();
        }

        $allSlotsForDate = $dateRecord->hours->flatMap(function ($hour) {
            return $hour->timeSlots->map(function ($slot) use ($hour) {
                return [
                    'id' => $slot->id,
                    'start_time' => $slot->start_time,
                    'end_time' => $slot->end_time,
                    'available' => $slot->is_available,
                    'hour_id' => $hour->id,
                ];
            });
        });

        $groupedSlots = $allSlotsForDate->groupBy(function ($slot) {
            return $slot['start_time'].'-'.$slot['end_time'];
        })->map(function ($group) {
            $availableCount = $group->where('available', true)->count();
            if ($availableCount > 0) {
                return [
                    'id' => $group->first()['id'], // ID de uno de los slots del intervalo
                    'start_time' => $group->first()['start_time'],
                    'end_time' => $group->first()['end_time'],
                    'available_count' => $availableCount,
                ];
            }

            return null; // Excluir intervalos sin slots disponibles
        })->filter()->values(); // Eliminar los null y reindexar

        return $groupedSlots;
    }

    public function getAvailableDates()
    {
        return $this->model->whereHas('hours.timeSlots', function ($query) {
            $query->where('is_available', true);
        })
            ->where('date', '>=', now()->format('Y-m-d'))
            ->pluck('date')
            ->toArray();
    }

    public function reserveTimeSlot(int $slotId)
    {
        return DB::table('time_slots')
            ->where('id', $slotId)
            ->update(['is_available' => false]);
    }
}
