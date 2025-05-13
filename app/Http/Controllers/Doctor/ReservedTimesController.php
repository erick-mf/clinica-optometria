<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Repositories\DoctorReservedTime\DoctorReservedTimeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservedTimesController extends Controller
{
    public function __construct(private readonly DoctorReservedTimeRepositoryInterface $doctorReservedTimeRepository) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = (int) Auth::user()->id;
        $reservedTimes = $this->doctorReservedTimeRepository->paginate(10, $userId);

        return view('doctor.reserved-times.index', [
            'reservedTimes' => $reservedTimes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'details' => 'required|string',
            'user_id' => 'required',
        ], [
            'date.required' => 'La fecha es requerida',
            'start_time.required' => 'La hora de inicio es requerida',
            'end_time.required' => 'La hora de fin es requerida',
            'end_time.after' => 'La hora de fin debe ser posterior a la hora de inicio',
            'details.required' => 'El motivo es requerido',
            'details.string' => 'El motivo debe ser una cadena de texto',
        ]);

        try {
            $this->doctorReservedTimeRepository->create($validated);

            return redirect()->route('reserved-times.index')->with('toast', ['type' => 'success', 'message' => 'Horario reservado correctamente']);
        } catch (\Exception $e) {
            Log::error('Error al crear el horario reservado: '.$e->getMessage());

            return back()->with('toast', ['type' => 'error', 'message' => 'Error al crear el horario reservado: '.$e->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $this->doctorReservedTimeRepository->delete($id);

            return redirect()->route('reserved-times.index')
                ->with('toast', ['type' => 'success', 'message' => 'Horario reservado eliminado correctamente']);
        } catch (\Exception $e) {
            Log::error('Error al eliminar el horario reservado: '.$e->getMessage());

            return back()->with('toast', ['type' => 'error', 'message' => 'Error al eliminar el horario reservado']);
        }
    }
}
