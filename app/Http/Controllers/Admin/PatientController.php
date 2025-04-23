<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Repositories\Patient\PatientRepositoryInterface;
use App\Http\Requests\AdminPatientRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(private readonly PatientRepositoryInterface $repository) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $validated = $request->validate([
            'search' => 'nullable|string|min:3|max:100',
        ]);

        if ($request->filled('search')) {
            $patients = $this->repository->search($validated['search']);
        } else {
            $patients = $this->repository->paginate();
        }

        return view('admin.patients.index', compact('patients'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminPatientRequest $request) // Usar AdminPatientRequest
    {
        $validated = $request->validated(); // Validar automáticamente con AdminPatientRequest

        try {
            $patient = $this->repository->create($validated);

            return redirect()
                ->route('admin.patients.index')
                ->with('toast', ['type' => 'success', 'message' => 'Paciente creado correctamente.']);
        } catch (\Exception $e) {
            Log::error("Error al crear el paciente: {$e->getMessage()}");

            return back()
                ->with('toast', ['type' => 'error', 'message' => 'Error al crear el paciente.'])
                ->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminPatientRequest $request, Patient $patient) // Usar AdminPatientRequest
    {
        $validated = $request->validated(); // Validar automáticamente con AdminPatientRequest

        try {
            $this->repository->update($patient, $validated);

            return redirect()
                ->route('admin.patients.index')
                ->with('toast', ['type' => 'success', 'message' => 'Paciente actualizado correctamente.']);
        } catch (\Exception $e) {
            Log::error("Error al actualizar al paciente: {$e->getMessage()}");

            return back()->withInput()->with('toast', ['type' => 'error', 'message' => 'Error al actualizar al paciente.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        try {
            $this->repository->delete($patient);

            return redirect()
                ->route('admin.patients.index')
                ->with('toast', ['type' => 'success', 'message' => 'Paciente eliminado correctamente.']);
        } catch (\Exception $e) {
            Log::error("Error al eliminar al paciente: {$e->getMessage()}");

            return back()->withInput()->with('toast', ['type' => 'error', 'message' => 'Error al eliminar al paciente.']);
        }
    }
}
