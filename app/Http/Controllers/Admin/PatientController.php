<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Repositories\Patient\PatientRepositoryInterface;

class PatientController extends Controller
{
    public function __construct(private readonly PatientRepositoryInterface $repository)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $patients = $this->repository->searchPaginate($search);
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
     * Update the specified resource in storage.
     */
    public function update(Patient $patient, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'surnames' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users,email,'.$patient->id,
            'phone' => 'nullable|string|max:9|regex:/^[0-9\s\-]+$/',
            'dni' => 'required|max:9|regex:/^[XYZ]?\d{7,8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'surnames.required' => 'Los apellidos son obligatorios.',
            'surnames.max' => 'Los apellidos no pueden tener más de 255 caracteres.',
            'surnames.regex' => 'Los apellidos solo pueden contener letras y espacios.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'phone.max' => 'El teléfono no puede tener más de 9 números.',
            'phone.regex' => 'El teléfono solo puede contener números, espacios y guiones.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.max' => 'El DNI no puede tener más de 9 caracteres.',
            'dni.regex' => 'El DNI solo puede contener 8 números y 1 letra.',
        ]);

        $this->repository->update($patient, $validated);

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Paciente actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
        $this->repository->delete($patient);

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Paciente eliminado correctamente.');
    }
}
