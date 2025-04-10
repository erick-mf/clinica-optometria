<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Appointment\AppointmentRepositoryInterface;

class DashboardController extends Controller
{
    public function __construct(
        private readonly AppointmentRepositoryInterface $appointmentRepository
    ) {}

    public function index()
    {
        $appointments = $this->appointmentRepository->appointmentTodayPaginated();

        return view('admin.dashboard', compact('appointments'));
    }
}
