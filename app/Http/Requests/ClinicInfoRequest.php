<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClinicInfoRequest extends FormRequest
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
        return [
            'direction' => 'required|string|max:1000',

            'attention_month_ranges' => 'present|array',
            'attention_month_ranges.*.start_month' => 'nullable|required_with:attention_month_ranges.*.end_month|integer|min:1|max:12',
            'attention_month_ranges.*.end_month' => 'nullable|required_with:attention_month_ranges.*.start_month|integer|min:1|max:12|gte:attention_month_ranges.*.start_month',

            'operating_hour_patterns' => 'present|array',
            'operating_hour_patterns.*.active_days' => 'sometimes|array',
            'operating_hour_patterns.*.active_days.*' => 'string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'operating_hour_patterns.*.time_slots' => 'nullable|array|min:0',
            'operating_hour_patterns.*.time_slots.*.start_time' => 'required_with:operating_hour_patterns.*.time_slots|date_format:H:i',
            'operating_hour_patterns.*.time_slots.*.end_time' => 'required_with:operating_hour_patterns.*.time_slots|date_format:H:i|after:operating_hour_patterns.*.time_slots.*.start_time',
        ];
    }

    public function messages(): array
    {
        return [
            'direction.required' => 'La dirección de la clínica es obligatoria.',

            'attention_month_ranges.*.start_month.required_with' => 'El mes de inicio es obligatorio si se especifica un mes de fin para el rango.',
            'attention_month_ranges.*.end_month.required_with' => 'El mes de fin es obligatorio si se especifica un mes de inicio para el rango.',
            'attention_month_ranges.*.end_month.gte' => 'El mes de fin del rango debe ser igual o posterior al mes de inicio.',

            'operating_hour_patterns.*.time_slots.required_if' => 'Debe definir al menos un turno si ha seleccionado días para el patrón.',
            'operating_hour_patterns.*.time_slots.*.start_time.required_with' => 'La hora de inicio del turno es obligatoria.',
            'operating_hour_patterns.*.time_slots.*.end_time.required_with' => 'La hora de fin del turno es obligatoria.',
            'operating_hour_patterns.*.time_slots.*.end_time.after' => 'La hora de fin del turno debe ser posterior a la hora de inicio.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'attention_month_ranges' => $this->input('attention_month_ranges', []),
            'operating_hour_patterns' => $this->input('operating_hour_patterns', []),
        ]);
    }
}
