<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SetupPassword;
use App\Repositories\Doctor\DoctorRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;

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
            'name' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[\p{L}\s]+$/u', Rule::unique('users')->ignore($request['id'], 'id')],
            'surnames' => 'required|string|min:3|max:255|regex:/^[\p{L}\s]+$/u',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|digits:9|regex:/^[6-9]\d{8}$/|numeric',
            'role' => 'required',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'name.regex' => 'El nombre solo puede contener letras y espacios.',

            'surnames.required' => 'Los apellidos son obligatorios.',
            'surnames.string' => 'Los apellidos deben ser una cadena de texto.',
            'surnames.min' => 'Los apellidos deben tener al menos 3 caracteres.',
            'surnames.max' => 'Los apellidos no pueden tener más de 255 caracteres.',
            'surnames.regex' => 'Los apellidos solo pueden contener letras y espacios.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.unique' => 'El correo electrónico ya está en uso.',

            'phone.digits' => 'El teléfono debe tener 9 dígitos.',
            'phone.regex' => 'El teléfono debe comenzar con 6, 7, 8 o 9.',
            'phone.numeric' => 'El teléfono solo puede contener números.',

            'role.required' => 'El rol es obligatorio.',
        ]);

        DB::beginTransaction();

        try {
            $doctor = $this->repository->create($validated);

            if (! $doctor) {
                throw new Exception('Error al crear el profesional.');
            }

            $token = Password::createToken($doctor);
            $doctor->notify(new SetupPassword($token));

            DB::commit();

            return redirect()
                ->route('admin.doctors.index')
                ->with('toast', ['type' => 'success', 'message' => 'Profesional creado correctamente.']);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error al crear doctor: '.$e->getMessage());

            return back()->withInput()->with('toast', [
                'type' => 'error',
                'message' => 'Hubo un error al crear el profesional.',
            ]);
        }

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
            'phone' => 'nullable|string|max:9|regex:/^[0-9\s\-]+$/',
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

        try {
            $this->repository->update($doctor, $validated);

            return redirect()
                ->route('admin.doctors.index')
                ->with('toast', ['type' => 'success', 'message' => 'Profesional actualizado correctamente.']);
        } catch (\Exception $e) {
            Log::error("Error al actualizar al profesional: {$e->getMessage()}");

            return back()->withInput()->with('toast', ['type' => 'error', 'message' => 'Error al actualizar al profesional.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $doctor)
    {
        try {
            $deleted = $this->repository->delete($doctor);
            if ($deleted['error']) {
                return back()->withInput()->with('toast', ['type' => 'error', 'message' => $deleted['error']]);
            }

            return redirect()
                ->route('admin.doctors.index')
                ->with('toast', ['type' => 'success', 'message' => 'Profesional eliminado correctamente.']);
        } catch (\Exception $e) {
            Log::error("Error al eliminar al profesional: {$e->getMessage()}");

            return back()->withInput()->with('toast', ['type' => 'error', 'message' => 'Error al eliminar al profesional.']);
        }
    }

    public function resendSetupLink(User $doctor)
    {
        if (! $doctor->password) {
            $token = Password::createToken($doctor);
            $doctor->notify(new SetupPassword($token));

            return back()->with('toast', [
                'type' => 'success',
                'message' => 'Correo reenviado correctamente para configurar la contraseña.',
            ]);
        }

        return back()->with('toast', [
            'type' => 'info',
            'message' => 'Este usuario ya tiene una contraseña configurada.',
        ]);
    }
}
