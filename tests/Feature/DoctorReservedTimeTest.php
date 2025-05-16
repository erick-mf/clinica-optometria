<?php

namespace Tests\Feature\Repositories\DoctorReservedTime;

use App\Models\DoctorReservedTime;
use App\Models\Office;
use App\Models\User;
use App\Repositories\AvailableHour\AvailableHourRepositoryInterface;
use App\Repositories\DoctorReservedTime\EloquentDoctorReservedTimeRepository;
use Exception;
use Mockery;

// Preparamos las herramientas que usaremos en los tests
$mockHorasDisponibles = null;
$modeloReserva = null;
$repositorio = null;

// Esto se ejecuta antes de cada test
beforeEach(function () use (&$mockHorasDisponibles, &$modeloReserva, &$repositorio) {
    // Creamos un simulacro del repositorio de horas disponibles
    $mockHorasDisponibles = Mockery::mock(AvailableHourRepositoryInterface::class);

    // Creamos un modelo de reserva vacío
    $modeloReserva = new DoctorReservedTime;

    // Creamos el repositorio que vamos a probar
    $repositorio = new EloquentDoctorReservedTimeRepository(
        $modeloReserva,
        $mockHorasDisponibles
    );
});

// Limpiamos después de cada test
afterEach(function () {
    Mockery::close();
});

/******************************************
 * TESTS PRINCIPALES
 ******************************************/

test('crear una reserva nueva correctamente', function () use (&$repositorio, &$mockHorasDisponibles) {
    // PREPARACIÓN: Creamos doctor y oficina
    $doctor = User::factory()->create(['role' => 'doctor']);
    $oficina = Office::factory()->create();

    // Configuramos el mock para decir que NO hay conflicto con horas disponibles
    $mockHorasDisponibles->shouldReceive('checkAvailabilityConflict')
        ->once()
        ->with($oficina->id, '2025-05-20', '09:00:00', '10:00:00')
        ->andReturn(false);

    // Datos para la reserva
    $datosReserva = [
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '09:00:00',
        'end_time' => '10:00:00',
        'details' => 'Reunión de equipo',
    ];

    // ACCIÓN: Creamos la reserva
    $resultado = $repositorio->create($datosReserva);

    // VERIFICACIÓN:
    // 1. Que devuelva un objeto de tipo DoctorReservedTime
    expect($resultado)->toBeInstanceOf(DoctorReservedTime::class);

    // 2. Que los datos coincidan
    expect($resultado->user_id)->toBe($doctor->id);
    expect($resultado->office_id)->toBe($oficina->id);
    expect($resultado->details)->toBe('Reunión de equipo');

    // 3. Que exista en la base de datos
    expect(DoctorReservedTime::where($datosReserva)->exists())->toBeTrue();
});

test('error cuando falta el ID de la oficina', function () use (&$repositorio) {
    // PREPARACIÓN: Creamos solo el doctor
    $doctor = User::factory()->create(['role' => 'doctor']);

    // Datos incompletos (falta office_id)
    $datosInvalidos = [
        'user_id' => $doctor->id,
        'date' => '2025-05-20',
        'start_time' => '09:00:00',
        'end_time' => '10:00:00',
        'details' => 'Reunión sin oficina',
    ];

    // ACCIÓN Y VERIFICACIÓN:
    // Esperamos que al crear lance una excepción con el mensaje correcto
    expect(fn () => $repositorio->create($datosInvalidos))
        ->toThrow(Exception::class, 'El campo office_id es obligatorio para crear una reserva');

    // Verificamos que no se creó en la base de datos
    expect(DoctorReservedTime::where('details', 'Reunión sin oficina')->exists())->toBeFalse();
});

test('error cuando se solapa con otra reserva', function () use (&$repositorio, &$mockHorasDisponibles) {
    // PREPARACIÓN: Creamos doctor, oficina y una reserva existente
    $doctor = User::factory()->create(['role' => 'doctor']);
    $oficina = Office::factory()->create();

    DoctorReservedTime::factory()->create([
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '09:30:00',
        'end_time' => '10:30:00',
    ]);

    // No debería verificar horas disponibles porque ya hay conflicto con otra reserva
    $mockHorasDisponibles->shouldReceive('checkAvailabilityConflict')->never();

    // Datos que entran en conflicto con la reserva existente
    $datosConflicto = [
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '10:00:00', // Se solapa con la reserva existente (10:00-11:00 vs 09:30-10:30)
        'end_time' => '11:00:00',
        'details' => 'Reunión conflictiva',
    ];

    // ACCIÓN Y VERIFICACIÓN:
    expect(fn () => $repositorio->create($datosConflicto))
        ->toThrow(Exception::class, 'El horario seleccionado se solapa con otra reserva en esta oficina');

    expect(DoctorReservedTime::where('details', 'Reunión conflictiva')->exists())->toBeFalse();
});

test('error cuando se solapa con un horario disponible', function () use (&$repositorio, &$mockHorasDisponibles) {
    // PREPARACIÓN: Creamos doctor y oficina
    $doctor = User::factory()->create(['role' => 'doctor']);
    $oficina = Office::factory()->create();

    // Configuramos el mock para decir que SÍ hay conflicto con horas disponibles
    $mockHorasDisponibles->shouldReceive('checkAvailabilityConflict')
        ->once()
        ->with($oficina->id, '2025-05-20', '14:30:00', '15:30:00')
        ->andReturn(true);

    // Datos que entran en conflicto con un horario disponible
    $datosConflicto = [
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '14:30:00',
        'end_time' => '15:30:00',
        'details' => 'Reunión que quita horario a pacientes',
    ];

    // ACCIÓN Y VERIFICACIÓN:
    expect(fn () => $repositorio->create($datosConflicto))
        ->toThrow(Exception::class, 'El horario colisiona con un horario disponible para pacientes');

    expect(DoctorReservedTime::where('details', 'Reunión que quita horario a pacientes')->exists())->toBeFalse();
});

test('crear reserva cuando no hay solapamientos', function () use (&$repositorio, &$mockHorasDisponibles) {
    // PREPARACIÓN: Creamos doctor, oficina y una reserva existente
    $doctor = User::factory()->create(['role' => 'doctor']);
    $oficina = Office::factory()->create();

    DoctorReservedTime::factory()->create([
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '09:00:00',
        'end_time' => '10:00:00',
    ]);

    // Configuramos el mock para decir que NO hay conflicto con horas disponibles
    $mockHorasDisponibles->shouldReceive('checkAvailabilityConflict')
        ->once()
        ->with($oficina->id, '2025-05-20', '11:00:00', '12:00:00')
        ->andReturn(false);

    // Datos que NO entran en conflicto
    $datosSinConflicto = [
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '11:00:00',
        'end_time' => '12:00:00',
        'details' => 'Reunión segura',
    ];

    // ACCIÓN: Creamos la reserva
    $resultado = $repositorio->create($datosSinConflicto);

    // VERIFICACIÓN:
    expect($resultado)->toBeInstanceOf(DoctorReservedTime::class);
    expect($resultado->start_time)->toBe('11:00:00');
    expect($resultado->end_time)->toBe('12:00:00');
    expect(DoctorReservedTime::where('details', 'Reunión segura')->exists())->toBeTrue();
});

test('error cuando la nueva reserva está completamente dentro de una existente', function () use (&$repositorio, &$mockHorasDisponibles) {
    // PREPARACIÓN:
    $doctor = User::factory()->create(['role' => 'doctor']);
    $oficina = Office::factory()->create();

    // Reserva existente más larga (09:00-11:00)
    DoctorReservedTime::factory()->create([
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '09:00:00',
        'end_time' => '11:00:00',
    ]);

    // No debería verificar horas disponibles porque ya hay conflicto
    $mockHorasDisponibles->shouldReceive('checkAvailabilityConflict')->never();

    // Nueva reserva completamente dentro de la existente (09:30-10:30)
    $datosContenidos = [
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '09:30:00',
        'end_time' => '10:30:00',
        'details' => 'Reunión dentro de otra',
    ];

    // ACCIÓN Y VERIFICACIÓN:
    expect(fn () => $repositorio->create($datosContenidos))
        ->toThrow(Exception::class, 'El horario seleccionado se solapa con otra reserva en esta oficina');

    expect(DoctorReservedTime::where('details', 'Reunión dentro de otra')->exists())->toBeFalse();
});

test('error cuando la nueva reserva contiene completamente una existente', function () use (&$repositorio, &$mockHorasDisponibles) {
    // PREPARACIÓN:
    $doctor = User::factory()->create(['role' => 'doctor']);
    $oficina = Office::factory()->create();

    // Reserva existente más corta (09:30-10:30)
    DoctorReservedTime::factory()->create([
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '09:30:00',
        'end_time' => '10:30:00',
    ]);

    // No debería verificar horas disponibles porque ya hay conflicto
    $mockHorasDisponibles->shouldReceive('checkAvailabilityConflict')->never();

    // Nueva reserva que contiene completamente la existente (09:00-11:00)
    $datosContenedores = [
        'user_id' => $doctor->id,
        'office_id' => $oficina->id,
        'date' => '2025-05-20',
        'start_time' => '09:00:00',
        'end_time' => '11:00:00',
        'details' => 'Reunión que contiene otra',
    ];

    // ACCIÓN Y VERIFICACIÓN:
    expect(fn () => $repositorio->create($datosContenedores))
        ->toThrow(Exception::class, 'El horario seleccionado se solapa con otra reserva en esta oficina');

    expect(DoctorReservedTime::where('details', 'Reunión que contiene otra')->exists())->toBeFalse();
});
