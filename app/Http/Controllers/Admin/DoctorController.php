<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Doctor\DoctorRepositoryInterface;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct(private readonly DoctorRepositoryInterface $repository) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = $this->repository->paginate();

        return view('admin.doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'surnames' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20|regex:/^[0-9\s\-]+$/',
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
            'phone.max' => 'El teléfono no puede tener más de 20 caracteres.',
            'phone.regex' => 'El teléfono solo puede contener números, espacios y guiones.',
        ]);

        $doctor = $this->repository->create($validated);

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Doctor creado correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $doctor, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'surnames' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users,email,'.$doctor->id,
            'phone' => 'nullable|string|max:20|regex:/^[0-9\s\-+]+$/',
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
            'phone.max' => 'El teléfono no puede tener más de 20 caracteres.',
            'phone.regex' => 'El teléfono solo puede contener números, espacios, guiones y signos de suma.',
        ]);

        $this->repository->update($doctor, $validated);

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Doctor actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $doctor)
    {
        $this->repository->delete($doctor);

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Doctor eliminado correctamente.');
    }
}
