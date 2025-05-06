<?php

use App\Http\Requests\AdminPatientRequest;
use App\Models\Patient;
use Illuminate\Support\Facades\Validator;

uses()->group('validation');

test('dni must be unique - already exists in uppercase', function () {
    Patient::factory()->create([
        'dni' => '47575922T',
    ]);

    $data = [
        'name' => 'Random',
        'surnames' => 'Apellido',
        'birthdate' => '1990-01-01',
        'email' => 'random@example.com',
        'phone' => '666666666',
        'dni' => '47575922t',
    ];

    $request = new AdminPatientRequest;
    $request->initialize($data);

    $rules = $request->rules();

    $validator = Validator::make($data, $rules);
    $fails = $validator->fails();

    expect($fails)->toBeTrue()
        ->and($validator->errors()->has('dni'))->toBeTrue()
        ->and($validator->errors()->first('dni'))->toBe('El DNI/NIE ya está registrado.');
});
