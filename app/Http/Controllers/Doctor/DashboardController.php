<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'doctors' => 5, // Número de doctores
            'patients' => 10, // Número de pacientes
            'appointments' => 8, // Número de citas
            'schedules' => 6, // Número de horarios
            'latestAppointments' => [
                ['patient' => 'Juan Pérez', 'doctor' => 'Dr. Gómez', 'date' => '2025-04-05 10:00'],
                ['patient' => 'Ana López', 'doctor' => 'Dr. García', 'date' => '2025-04-06 14:00'],
                ['patient' => 'Carlos Sánchez', 'doctor' => 'Dr. Rodríguez', 'date' => '2025-04-07 09:30'],
                ['patient' => 'Lucía Martín', 'doctor' => 'Dr. Fernández', 'date' => '2025-04-07 16:00'],
                ['patient' => 'Marta Ruiz', 'doctor' => 'Dr. González', 'date' => '2025-04-08 11:15'],
            ],
        ];

        return view('doctor.dashboard', compact('data'));
    }
}
