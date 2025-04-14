<?php

namespace App\Repositories\Appointment;

use App\Models\Appointment;

interface AppointmentRepositoryInterface
{
    public function paginate(int $perPage = 10);

    public function find($id);

    public function appointmentTodayPaginated(int $perPage = 15);

    public function create(array $data);

    public function update(Appointment $appointment, array $data);

    public function delete(Appointment $appointment);
}
