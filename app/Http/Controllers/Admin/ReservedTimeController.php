<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\DoctorReservedTime\DoctorReservedTimeRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class ReservedTimeController extends Controller
{
    public function __construct(private readonly DoctorReservedTimeRepositoryInterface $repository) {}

    public function index()
    {
        $reservations = $this->repository->paginateAll(10);

        return view('admin.reserved-times.index', compact('reservations'));
    }

    public function destroy($id)
    {
        try {
            $this->repository->delete($id);

            return back()->with('toast', ['type' => 'success', 'message' => 'Reserva eliminada correctamente']);
        } catch (Exception $e) {
            Log::error('Error al eliminar la reserva: '.$e->getMessage());

            return back()->with('toast', ['type' => 'error', 'message' => 'Error al eliminar la reserva']);
        }
    }
}
