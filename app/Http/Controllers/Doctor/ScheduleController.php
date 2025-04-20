<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Repositories\AvailableDate\AvailableDateRepositoryInterface;
use App\Repositories\Doctor\DoctorRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function __construct(
        private readonly AvailableDateRepositoryInterface $availableDateRepository,
        private readonly DoctorRepositoryInterface $doctorRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nextDate = null;
        $schedules = $this->doctorRepository->getScheduleByDoctor(Auth::user()->id);
        $dateCarbon = $this->availableDateRepository->getNextDate();
        if (! $dateCarbon) {
            $nextDate = 'N/A';
        } else {
            $nextDate = Carbon::parse($dateCarbon->date)->format('d/m/Y');
        }

        return view('doctor.schedules.index', compact('schedules', 'nextDate'));
    }
}
