<?php

namespace App\Http\Requests;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $age = 0;
        if ($this->filled('birthdate')) {
            $age = date('Y') - date('Y', strtotime($this->birthdate));
        }

        $rules = [
            // Datos personales
            'name' => 'required|string|regex:/^[A-Za-záéíóúüÁÉÍÓÚÜñÑ\s]+$/|max:255',
            'surnames' => 'required|string|regex:/^[A-Za-záéíóúüÁÉÍÓÚÜñÑ\s]+$/|max:255',
            'birthdate' => 'required|date|before:today',
        ];

        if ($age < 18) {
            // Si es menor
            $rules['email'] = 'nullable|email|max:255';
            $rules['dni'] = 'nullable|max:9|regex:/^[XYZ]?\d{7,8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i';
            $rules['phone'] = 'nullable|digits:9|regex:/^[6-9]\d{8}$/';
            // Datos del tutor son obligatorios
            $rules['tutor_name'] = 'required|string|regex:/^[A-Za-záéíóúüÁÉÍÓÚÜñÑ\s]+$/|max:255';
            $rules['tutor_email'] = 'required|email|max:255';
            $rules['tutor_dni'] = 'required|max:9|regex:/^[XYZ]?\d{7,8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i';
            $rules['tutor_phone'] = 'required|digits:9|regex:/^[6-9]\d{8}$/';
        } else {
            // Si es adulto
            $rules['email'] = 'required|email|max:255';
            $rules['phone'] = 'required|digits:9|regex:/^[6-9]\d{8}$/';
            $rules['dni'] = 'required|max:9|regex:/^[XYZ]?\d{7,8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i';

            // Campos del tutor son opcionales para adultos
            $rules['tutor_name'] = 'nullable|string|regex:/^[A-Za-záéíóúüÁÉÍÓÚÜñÑ\s]+$/|max:255';
            $rules['tutor_email'] = 'nullable|email|max:255';
            $rules['tutor_dni'] = 'nullable|max:9|regex:/^[XYZ]?\d{7,8}[TRWAGMYFPDXBNJZSQVHLCKE]$/i';
            $rules['tutor_phone'] = 'nullable|digits:9|regex:/^[6-9]\d{8}$/';
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
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',

            'surnames.required' => 'Los apellidos son obligatorios.',
            'surnames.string' => 'Los apellidos deben ser texto.',
            'surnames.regex' => 'Los apellidos solo pueden contener letras y espacios.',
            'surnames.max' => 'Los apellidos no pueden tener más de 255 caracteres.',

            'birthdate.required' => 'La fecha de nacimiento es obligatoria.',
            'birthdate.date' => 'La fecha de nacimiento debe tener un formato válido.',
            'birthdate.before' => 'La fecha de nacimiento debe ser anterior a hoy.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe introducir un correo electrónico válido.',
            'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',

            'phone.required' => 'El teléfono es obligatorio.',
            'phone.digits' => 'El teléfono debe tener 9 dígitos.',
            'phone.regex' => 'El teléfono debe comenzar por 6, 7, 8 o 9.',

            'dni.required' => 'El DNI/NIE es obligatorio.',
            'dni.max' => 'El DNI/NIE no puede tener más de 9 caracteres.',
            'dni.regex' => 'El formato del DNI/NIE no es válido.',

            // Datos del tutor
            'tutor_name.required' => 'El nombre del tutor es obligatorio para menores de edad.',
            'tutor_name.string' => 'El nombre del tutor debe ser texto.',
            'tutor_name.regex' => 'El nombre del tutor solo puede contener letras y espacios.',
            'tutor_name.max' => 'El nombre del tutor no puede tener más de 255 caracteres.',

            'tutor_email.required' => 'El correo electrónico del tutor es obligatorio para menores de edad.',
            'tutor_email.email' => 'Debe introducir un correo electrónico válido para el tutor.',
            'tutor_email.max' => 'El correo electrónico del tutor no puede tener más de 255 caracteres.',

            'tutor_dni.required' => 'El DNI/NIE del tutor es obligatorio para menores de edad.',
            'tutor_dni.max' => 'El DNI/NIE del tutor no puede tener más de 9 caracteres.',
            'tutor_dni.regex' => 'El formato del DNI/NIE del tutor no es válido.',

            'tutor_phone.required' => 'El teléfono del tutor es obligatorio para menores de edad.',
            'tutor_phone.digits' => 'El teléfono del tutor debe tener 9 dígitos.',
            'tutor_phone.regex' => 'El teléfono del tutor debe comenzar por 6, 7, 8 o 9.',
        ];
    }
}