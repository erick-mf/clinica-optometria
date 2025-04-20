<?php

namespace App\Repositories\Patient;

use App\Models\Patient;

interface PatientRepositoryInterface
{
    /**
     * Get paginated list of patients
     *
     * @param  int  $perPage  Number of items per page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = 10);

    /**
     * Search patients by specific criteria
     *
     * @param  string  $search  Search term
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search(string $search);

    /**
     * Get all patients
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all();

    /**
     * Find a patient by DNI
     *
     * @param  mixed  $dni  Patient's DNI (identification number)
     * @return \App\Models\Patient|null
     */
    public function find($dni);

    /**
     * Find a patient by identity
     *
     * @param  array  $data  Patient data
     * @return \App\Models\Patient|null
     */
    public function findByIdentity(array $data);

    /**
     * Create a new patient
     *
     * @param  array  $data  Patient data
     * @return \App\Models\Patient
     */
    public function create(array $data);

    /**
     * Update a patient's data
     *
     * @param  \App\Models\Patient  $user  Patient instance to update
     * @param  array  $data  New patient data
     * @return \App\Models\Patient
     */
    public function update(Patient $user, array $data);

    /**
     * Delete a patient
     *
     * @param  \App\Models\Patient  $user  Patient instance to delete
     * @return bool
     */
    public function delete(Patient $user);
}
