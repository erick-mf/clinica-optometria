<?php

namespace App\Http\Controllers\Admin;

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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'surnames' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users,email,',
            'phone' => 'nullable|string|max:9|regex:/^[0-9\s\-]+$/',
            'dni' => 'required|max:9|regex:/^[XYZ]?\d{7,8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i',
            'birthdate' => 'required|date',
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
            'birthdate.required' => 'La fecha de nacimiento es obligatoria.',
            'birthdate.date' => 'La fecha de nacimiento debe ser una fecha v&aacute;lida.',
        ]);

        $patient = $this->repository->create($validated);

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Paciente creado correctamente.');
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
        $this->repository->delete($patient);

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Paciente eliminado correctamente.');
    }
}
