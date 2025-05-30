<?php

namespace App\Repositories\Doctor;

use App\Models\User;

interface DoctorRepositoryInterface
{
    /**
     * Get paginated list of doctors
     *
     * @param  int  $perPage  Number of items per page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = 10);

    /**
     * Get all doctors
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all();

    /**
     * Find a doctor by ID
     *
     * @param  mixed  $id  Doctor's ID
     * @return \App\Models\User|null
     */
    public function find($id);

    /**
     * Create a new doctor
     *
     * @param  array  $data  Doctor data
     * @return \App\Models\User
     */
    public function create(array $data);

    /**
     * Update a doctor's data
     *
     * @param  \App\Models\User  $user  Doctor instance to update
     * @param  array  $data  New doctor data
     * @return \App\Models\User
     */
    public function update(User $user, array $data);

    /**
     * Delete a doctor
     *
     * @param  \App\Models\User  $user  Doctor instance to delete
     * @return bool
     */
    public function delete(User $user);

    /**
     * Get a specific doctor's schedule
     *
     * @param  mixed  $id  Doctor's ID
     * @return mixed
     */
    public function getScheduleByDoctor($id);

    /**
     * Get doctors with their schedules
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDoctorWithSchedule();

    public function getDoctorsWithOffices();
}
