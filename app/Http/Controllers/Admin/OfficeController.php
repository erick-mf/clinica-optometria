<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Repositories\Doctor\DoctorRepositoryInterface;
use App\Repositories\Office\OfficeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OfficeController extends Controller
{
    public function __construct(
        private readonly OfficeRepositoryInterface $officeRepository,
        private readonly DoctorRepositoryInterface $doctorRepository) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offices = $this->officeRepository->all();
        $doctors = $this->doctorRepository->all();

        return view('admin.offices.index', [
            'offices' => $offices,
            'isEdit' => false,
            'doctors' => $doctors,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request['name'] = ucwords(strtolower($request['name']));
        $request['abbreviation'] = strtoupper($request['abbreviation']) ?? null;

        $validated = $request->validate([
            'name' => 'required|string|unique:offices',
            'abbreviation' => 'nullable|max:10|unique:offices',
            'status' => 'required',
            'user_id' => 'nullable',
        ], [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.unique' => 'El nombre ya está en uso',
            'abbreviation.max' => 'La abreviatura debe tener máximo 10 caracteres',
            'abbreviation.unique' => 'La abreviatura ya está en uso',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.unique' => 'El nombre ya está en uso',
            'status.required' => 'El estado es requerido',
        ]);

        try {
            $existOffice = $this->officeRepository->create($validated);

            if (! $existOffice) {
                return back()->with('toast', ['type' => 'error', 'message' => 'El usuario ya tiene un espacio asignado'])->withInput();
            }

            return redirect()->route('admin.offices.index')->with('toast', ['type' => 'success', 'message' => 'Espacio creado correctamente']);
        } catch (\Exception $e) {
            Log::error('Error al crear el espacio: '.$e->getMessage());

            return back()->with('toast', ['type' => 'error', 'message' => 'Error al crear el espacio'])->withInput();
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Office $office)
    {
        $offices = $this->officeRepository->all();
        $doctors = $this->doctorRepository->all();

        return view('admin.offices.index', [
            'doctors' => $doctors,
            'offices' => $offices,
            'office' => $office,
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Office $office)
    {
        $validated = $request->validate([
            'name' => 'required',
            'status' => 'required',
            'user_id' => 'nullable',
        ]);

        try {
            $updateOffice = $this->officeRepository->update($office, $validated);

            if (! $updateOffice) {
                return back()->with('toast', ['type' => 'error', 'message' => 'El usuario ya tiene un espacio asignado'])->withInput();
            }

            return redirect()->route('admin.offices.index')->with('toast', ['type' => 'success', 'message' => 'Espacio actualizado correctamente']);
        } catch (\Exception $e) {
            Log::error('Error al actualizar el espacio: '.$e->getMessage());

            return back()->with('toast', ['type' => 'error', 'message' => 'Error al actualizar el espacio'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Office $office)
    {
        try {
            $this->officeRepository->delete($office);

            return redirect()->route('admin.offices.index')->with('toast', ['type' => 'success', 'message' => 'Espacio eliminado correctamente']);
        } catch (\Exception $e) {
            Log::error('Error al eliminar el espacio: '.$e->getMessage());

            return back()->with('toast', ['type' => 'error', 'message' => 'Error al eliminar el espacio'])->withInput();
        }
    }
}
