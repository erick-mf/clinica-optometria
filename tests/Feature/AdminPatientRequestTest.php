<?php

use App\Http\Requests\AdminPatientRequest;
use App\Models\Patient;
use Illuminate\Support\Facades\Validator;

uses()->group('validation');

test('dni must be unique - already exists in uppercase', function () {
    Patient::factory()->create([
        'document_type' => 'DNI',
        'document_number' => '67011201B',
    ]);

    $data = [
        'name' => 'Random',
        'surnames' => 'Apellido',
        'birthdate' => '1990-01-01',
        'email' => 'random@example.com',
        'phone' => '666666666',
        'document_type' => 'DNI',
        'document_number' => '67011201b',
    ];

    $request = new AdminPatientRequest;
    $request->initialize($data);

    $rules = $request->rules();

    $validator = Validator::make($data, $rules);
    $fails = $validator->fails();

    expect($fails)->toBeTrue()
        ->and($validator->errors()->has('document_number'))->toBeTrue()
        ->and($validator->errors()->first('document_number'))->toBe('El documento ya está registrado en el sistema.');
});
