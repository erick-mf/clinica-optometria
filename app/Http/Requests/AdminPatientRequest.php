<?php

namespace App\Http\Requests;

use App\Models\Patient;
use Illuminate\Foundation\Http\FormRequest;

class AdminPatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'name' => $this->name ? ucwords(strtolower($this->name)) : null,
            'surnames' => $this->surnames ? ucwords(strtolower($this->surnames)) : null,
            'email' => $this->email ? strtolower($this->email) : null,
            'document_type' => $this->document_type ?? null,
            'document_number' => $this->document_number ? strtoupper($this->document_number) : null,
            'tutor_name' => $this->tutor_name ? ucwords(strtolower($this->tutor_name)) : null,
            'tutor_email' => $this->tutor_email ? strtolower($this->tutor_email) : null,
            'tutor_document_type' => $this->tutor_document_type ?? null,
            'tutor_document_number' => $this->tutor_document_number ? strtoupper($this->tutor_document_number) : null,
        ]);
    }

    public function isValidDni($dni)
    {
        $dni = strtoupper(trim($dni));
        $pattern_dni = '/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i';

        if (! preg_match($pattern_dni, $dni)) {
            return false;
        }

        // Validar la letra del DNI
        $number = substr($dni, 0, 8);
        $letter = substr($dni, 8, 1);
        $letters = 'TRWAGMYFPDXBNJZSQVHLCKE';
        $correctLetter = $letters[intval($number) % 23];

        return $letter == $correctLetter;
    }

    public function isValidNie($nie)
    {
        $nie = strtoupper(trim($nie));
        $pattern_nie = '/^[XYZ][0-9]{7}[TRWAGMYFPDXBNJZSQVHLCKE]$/i';

        if (! preg_match($pattern_nie, $nie)) {
            return false;
        }

        $first = $nie[0];
        $replace = '';

        if ($first == 'X') {
            $replace = '0';
        } elseif ($first == 'Y') {
            $replace = '1';
        } elseif ($first == 'Z') {
            $replace = '2';
        }

        $number = $replace.substr($nie, 1, 7);
        $letter = substr($nie, 8, 1);
        $letters = 'TRWAGMYFPDXBNJZSQVHLCKE';
        $correctLetter = $letters[intval($number) % 23];

        return $letter == $correctLetter;
    }

    public function isValidPassport($passport)
    {
        $passport = strtoupper(trim($passport));
        $pattern_passport = '/^[A-Z0-9]{6,12}$/i';

        return preg_match($pattern_passport, $passport);
    }

    public function isValidDocument($type, $value)
    {
        if (empty($type) || empty($value)) {
            return true;
        }

        $value = strtoupper(trim($value));

        if ($type == 'DNI') {
            return $this->isValidDni($value) ?: 'El DNI introducido no es válido.';
        }

        if ($type == 'NIE') {
            return $this->isValidNie($value) ?: 'El NIE introducido no es válido.';
        }

        if ($type == 'Pasaporte') {
            return $this->isValidPassport($value) ?: 'El pasaporte introducido no es válido.';
        }

        return 'El documento introducido no es válido.';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $age = null;
        if ($this->filled('birthdate')) {
            $age = date('Y') - date('Y', strtotime($this->birthdate));
        }

        $rules = [
            // Datos personales
            'name' => 'required|string|regex:/^[A-Za-záéíóúüÁÉÍÓÚÜñÑ\s]+$/|min:3|max:255',
            'surnames' => 'required|string|regex:/^[A-Za-záéíóúüÁÉÍÓÚÜñÑ\s]+$/|min:3|max:255',
            'birthdate' => 'required|date|before:today',
            'email' => 'nullable|email|max:255',
        ];

        if ($age !== null) {
            if ($age < 18) {
                // Si es menor
                $rules['document_type'] = 'nullable|in:DNI,NIE,Pasaporte';
                $rules['document_number'] = ['nullable', 'max:9', function ($attribute, $value, $fail) {
                    $type = $this->input('document_type');
                    if (empty($type) || empty($value)) {
                        return;
                    }

                    $result = $this->isValidDocument($type, $value);
                    if ($result !== true) {
                        $fail($result);
                    }
                }];
                $rules['phone'] = 'nullable|digits:9|regex:/^[6-9]\d{8}$/';

                // Datos del tutor son obligatorios para menores
                $rules['tutor_name'] = 'required|string|regex:/^[A-Za-záéíóúüÁÉÍÓÚÜñÑ\s]+$/|min:3|max:255';
                $rules['tutor_email'] = 'nullable|email|max:255';
                $rules['tutor_document_type'] = 'required|in:DNI,NIE,Pasaporte';
                $rules['tutor_document_number'] = ['required', 'max:9', function ($attribute, $value, $fail) {
                    $type = $this->input('tutor_document_type');
                    $result = $this->isValidDocument($type, $value);
                    if ($result !== true) {
                        $fail($result);
                    }
                }];
                $rules['tutor_phone'] = 'required|digits:9|regex:/^[6-9]\d{8}$/';
            } else {
                // Si es adulto
                $rules['document_type'] = 'required|in:DNI,NIE,Pasaporte';
                $rules['document_number'] = ['required', 'max:9', function ($attribute, $value, $fail) {
                    $type = $this->input('document_type');
                    $result = $this->isValidDocument($type, $value);
                    if ($result !== true) {
                        $fail($result);
                    }
                }, function ($attribute, $value, $fail) {
                    $type = $this->input('document_type');
                    $number = strtoupper(trim($value));

                    // Verificar si el documento ya existe
                    $exists = Patient::where('document_type', $type)
                        ->where('document_number', $number)
                        ->exists();

                    if ($exists) {
                        $fail('El documento ya está registrado en el sistema.');
                    }
                }];
                $rules['phone'] = 'required|digits:9|regex:/^[6-9]\d{8}$/';

                // Campos del tutor son opcionales para adultos
                $rules['tutor_name'] = 'nullable|string|regex:/^[A-Za-záéíóúüÁÉÍÓÚÜñÑ\s]+$/|min:3|max:255';
                $rules['tutor_email'] = 'nullable|email|max:255';
                $rules['tutor_document_type'] = 'nullable|in:DNI,NIE,Pasaporte';
                $rules['tutor_document_number'] = ['nullable', 'max:9', function ($attribute, $value, $fail) {
                    $type = $this->input('tutor_document_type');
                    if (empty($type) || empty($value)) {
                        return;
                    }

                    $result = $this->isValidDocument($type, $value);
                    if ($result !== true) {
                        $fail($result);
                    }
                }];
                $rules['tutor_phone'] = 'nullable|digits:9|regex:/^[6-9]\d{8}$/';
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            // Datos personales
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser texto.',
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',

            'surnames.required' => 'Los apellidos son obligatorios.',
            'surnames.string' => 'Los apellidos deben ser texto.',
            'surnames.regex' => 'Los apellidos solo pueden contener letras y espacios.',
            'surnames.min' => 'Los apellidos deben tener al menos 3 caracteres.',
            'surnames.max' => 'Los apellidos no pueden tener más de 255 caracteres.',

            'birthdate.required' => 'La fecha de nacimiento es obligatoria.',
            'birthdate.date' => 'La fecha de nacimiento debe tener un formato válido.',
            'birthdate.before' => 'La fecha de nacimiento debe ser anterior a hoy.',

            'email.email' => 'Debe introducir un correo electrónico válido.',
            'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',

            'phone.required' => 'El teléfono es obligatorio.',
            'phone.digits' => 'El teléfono debe tener 9 dígitos.',
            'phone.regex' => 'El teléfono debe comenzar por 6, 7, 8 o 9.',

            'document_type.required' => 'El tipo de documento es obligatorio.',
            'document_type.in' => 'El tipo de documento debe ser DNI, NIE o Pasaporte.',
            'document_number.required' => 'El número de documento es obligatorio.',
            'document_number.max' => 'El número de documento no puede tener más de 9 caracteres.',

            // Datos del tutor
            'tutor_name.required' => 'El nombre del tutor es obligatorio para menores de edad.',
            'tutor_name.string' => 'El nombre del tutor debe ser texto.',
            'tutor_name.regex' => 'El nombre del tutor solo puede contener letras y espacios.',
            'tutor_name.min' => 'El nombre del tutor debe tener al menos 3 caracteres.',
            'tutor_name.max' => 'El nombre del tutor no puede tener más de 255 caracteres.',

            'tutor_email.email' => 'Debe introducir un correo electrónico válido para el tutor.',
            'tutor_email.max' => 'El correo electrónico del tutor no puede tener más de 255 caracteres.',

            'tutor_document_type.required' => 'El tipo de documento del tutor es obligatorio para menores de edad.',
            'tutor_document_type.in' => 'El tipo de documento del tutor debe ser DNI, NIE o Pasaporte.',
            'tutor_document_number.required' => 'El número de documento del tutor es obligatorio para menores de edad.',
            'tutor_document_number.max' => 'El número de documento del tutor no puede tener más de 9 caracteres.',

            'tutor_phone.required' => 'El teléfono del tutor es obligatorio para menores de edad.',
            'tutor_phone.digits' => 'El teléfono del tutor debe tener 9 dígitos.',
            'tutor_phone.regex' => 'El teléfono del tutor debe comenzar por 6, 7, 8 o 9.',
        ];
    }
}
