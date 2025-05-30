<?php

namespace Tests\Feature\Repositories\DoctorReservedTime;

use App\Models\DoctorReservedTime;
use App\Models\Office;
use App\Models\User;
use App\Repositories\AvailableHour\AvailableHourRepositoryInterface;
use App\Repositories\DoctorReservedTime\EloquentDoctorReservedTimeRepository;
use Exception;
use Mockery;

$mockHorasDisponibles = null;
$modeloReserva = null;
$repositorio = null;

beforeEach(function () use (&$mockHorasDisponibles, &$modeloReserva, &$repositorio) {
    $mockHorasDisponibles = Mockery::mock(AvailableHourRepositoryInterface::class);
    $modeloReserva = new DoctorReservedTime;
    $repositorio = new EloquentDoctorReservedTimeRepository(
        $modeloReserva,
        $mockHorasDisponibles
    );
});

afterEach(function () {
    Mockery::close();
});

test('crear una reserva nueva correctamente', function () use (&$repositorio, &$mockHorasDisponibles) {
    $doctor = User::factory()->create(['role' => 'doctor']);
    $oficina = Office::factory()->create();

    $mockHorasDisponibles->shouldReceive('checkAvailabilityConflict')
        ->once()
        ->with($oficina->id, '2025-05-20', '09:00:00', '10:00:00')
        ->andReturn(false);

    $datosReserva = [
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '09:00:00',
        'end_time' => '10:00:00',
        'details' => 'Reunión de equipo',
    ];

    $resultado = $repositorio->create($datosReserva);

    expect($resultado)->toBeInstanceOf(DoctorReservedTime::class);

    expect($resultado->user_id)->toBe($doctor->id);
    expect($resultado->office_id)->toBe($oficina->id);
    expect($resultado->details)->toBe('Reunión de equipo');
    expect(DoctorReservedTime::where($datosReserva)->exists())->toBeTrue();
});

test('error cuando falta el ID de la oficina', function () use (&$repositorio) {
    $doctor = User::factory()->create(['role' => 'doctor']);

    $datosInvalidos = [
        'user_id' => $doctor->id,
        'date' => '2025-05-20',
        'start_time' => '09:00:00',
        'end_time' => '10:00:00',
        'details' => 'Reunión sin oficina',
    ];

    expect(fn () => $repositorio->create($datosInvalidos))
        ->toThrow(Exception::class, 'El campo office_id es obligatorio para crear una reserva');

    expect(DoctorReservedTime::where('details', 'Reunión sin oficina')->exists())->toBeFalse();
});

test('error cuando se solapa con otra reserva', function () use (&$repositorio, &$mockHorasDisponibles) {
    $doctor = User::factory()->create(['role' => 'doctor']);
    $oficina = Office::factory()->create();

    DoctorReservedTime::factory()->create([
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '09:30:00',
        'end_time' => '10:30:00',
    ]);

    $mockHorasDisponibles->shouldReceive('checkAvailabilityConflict')->never();

    $datosConflicto = [
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '10:00:00',
        'end_time' => '11:00:00',
        'details' => 'Reunión conflictiva',
    ];

    expect(fn () => $repositorio->create($datosConflicto))
        ->toThrow(Exception::class, 'El horario seleccionado se solapa con otra reserva en esta oficina');

    expect(DoctorReservedTime::where('details', 'Reunión conflictiva')->exists())->toBeFalse();
});

test('error cuando se solapa con un horario disponible', function () use (&$repositorio, &$mockHorasDisponibles) {
    $doctor = User::factory()->create(['role' => 'doctor']);
    $oficina = Office::factory()->create();

    $mockHorasDisponibles->shouldReceive('checkAvailabilityConflict')
        ->once()
        ->with($oficina->id, '2025-05-20', '14:30:00', '15:30:00')
        ->andReturn(true);

    $datosConflicto = [
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '14:30:00',
        'end_time' => '15:30:00',
        'details' => 'Reunión que quita horario a pacientes',
    ];

    expect(fn () => $repositorio->create($datosConflicto))
        ->toThrow(Exception::class, 'El horario colisiona con un horario disponible para pacientes');

    expect(DoctorReservedTime::where('details', 'Reunión que quita horario a pacientes')->exists())->toBeFalse();
});

test('crear reserva cuando no hay solapamientos', function () use (&$repositorio, &$mockHorasDisponibles) {
    $doctor = User::factory()->create(['role' => 'doctor']);
    $oficina = Office::factory()->create();

    DoctorReservedTime::factory()->create([
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '09:00:00',
        'end_time' => '10:00:00',
    ]);

    $mockHorasDisponibles->shouldReceive('checkAvailabilityConflict')
        ->once()
        ->with($oficina->id, '2025-05-20', '11:00:00', '12:00:00')
        ->andReturn(false);

    $datosSinConflicto = [
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '11:00:00',
        'end_time' => '12:00:00',
        'details' => 'Reunión segura',
    ];

    $resultado = $repositorio->create($datosSinConflicto);

    expect($resultado)->toBeInstanceOf(DoctorReservedTime::class);
    expect($resultado->start_time)->toBe('11:00:00');
    expect($resultado->end_time)->toBe('12:00:00');
    expect(DoctorReservedTime::where('details', 'Reunión segura')->exists())->toBeTrue();
});

test('error cuando la nueva reserva está completamente dentro de una existente', function () use (&$repositorio, &$mockHorasDisponibles) {
    $doctor = User::factory()->create(['role' => 'doctor']);
    $oficina = Office::factory()->create();

    DoctorReservedTime::factory()->create([
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '09:00:00',
        'end_time' => '11:00:00',
    ]);

    $mockHorasDisponibles->shouldReceive('checkAvailabilityConflict')->never();

    $datosContenidos = [
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '09:30:00',
        'end_time' => '10:30:00',
        'details' => 'Reunión dentro de otra',
    ];

    expect(fn () => $repositorio->create($datosContenidos))
        ->toThrow(Exception::class, 'El horario seleccionado se solapa con otra reserva en esta oficina');

    expect(DoctorReservedTime::where('details', 'Reunión dentro de otra')->exists())->toBeFalse();
});

test('error cuando la nueva reserva contiene completamente una existente', function () use (&$repositorio, &$mockHorasDisponibles) {
    $doctor = User::factory()->create(['role' => 'doctor']);
    $oficina = Office::factory()->create();

    DoctorReservedTime::factory()->create([
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '09:30:00',
        'end_time' => '10:30:00',
    ]);

    $mockHorasDisponibles->shouldReceive('checkAvailabilityConflict')->never();

    $datosContenedores = [
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '09:00:00',
        'end_time' => '11:00:00',
        'details' => 'Reunión que contiene otra',
    ];

    expect(fn () => $repositorio->create($datosContenedores))
        ->toThrow(Exception::class, 'El horario seleccionado se solapa con otra reserva en esta oficina');

    expect(DoctorReservedTime::where('details', 'Reunión que contiene otra')->exists())->toBeFalse();
});
