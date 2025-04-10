<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Patient\PatientRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    private PatientRepositoryInterface $repository;

    public function __construct(PatientRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener los pacientes del doctor autenticado con paginación
        $doctorId = auth()->id();
        $patients = $this->repository->paginateByDoctor($doctorId, 10);

        return view('doctor.patients.index', compact('patients'));
    }
}