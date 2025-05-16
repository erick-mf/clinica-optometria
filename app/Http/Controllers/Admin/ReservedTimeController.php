<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\DoctorReservedTime\DoctorReservedTimeRepositoryInterface;

class ReservedTimeController extends Controller
{
    public function __construct(private readonly DoctorReservedTimeRepositoryInterface $repository) {}

    public function index()
    {
        $reservations = $this->repository->paginateAll(10);

        return view('admin.reserved-times.index', compact('reservations'));
    }
}
