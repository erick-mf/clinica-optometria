<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Patient\PatientRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;

class PatientController extends Controller
{
    public function __construct(private readonly PatientRepositoryInterface $repository){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = $this->repository->paginate();
        return view('doctor.patients.index', compact('patients'));
    }

    public function show(Patient $patient)
    {
        return view('ShowDetailsPatient', compact('patient'));
    }
}