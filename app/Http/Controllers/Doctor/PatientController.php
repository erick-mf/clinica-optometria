<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Repositories\Patient\PatientRepositoryInterface;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(private readonly PatientRepositoryInterface $repository) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('s');
        $validated = $request->validate([
            's' => 'nullable|string|min:3|max:100',  function ($attribute, $value, $fail) {
                // Permitir texto con espacios para nombres
                $isText = preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u', $value);
                // Validar formato DNI/NIE
                $isDni = preg_match('/^[XYZ\d]\d{7,8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i', $value);
            },
        ]);

        if ($request->filled('s')) {
            $patients = $this->repository->search($validated['s']);
        } else {
            $patients = $this->repository->paginate();
        }

        return view('doctor.patients.index', compact('patients'));
    }

    public function show(Patient $patient)
    {
        return view('ShowDetailsPatient', compact('patient'));
    }
}
