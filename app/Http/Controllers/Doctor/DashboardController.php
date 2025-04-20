<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Repositories\Appointment\AppointmentRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        private readonly AppointmentRepositoryInterface $appointmentRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = $this->appointmentRepository->paginateByDoctor(Auth::user()->id);

        return view('doctor.dashboard', compact('appointments'));
    }
}
