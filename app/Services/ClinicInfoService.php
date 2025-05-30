<?php

namespace App\Services;

use App\Models\ClinicConfiguration;

class ClinicInfoService
{
    // Constantes para las claves de configuración
    const KEY_ADDRESS = 'clinic_address';

    const KEY_MONTH_RANGES = 'attention_month_ranges';

    const KEY_HOUR_PATTERNS = 'operating_hour_patterns';

    public function getClinicInfoFormData(): array
    {
        $directionValue = ClinicConfiguration::getByKey(self::KEY_ADDRESS, '');
        $direction = new \stdClass;
        $direction->direction = $directionValue;

        $attentionMonthRanges = ClinicConfiguration::getByKey(self::KEY_MONTH_RANGES, []);
        $operatingHourPatterns = ClinicConfiguration::getByKey(self::KEY_HOUR_PATTERNS, []);

        if (empty($attentionMonthRanges) && ! is_array(old('attention_month_ranges'))) {
            $attentionMonthRanges = [['start_month' => '', 'end_month' => '']];
        }
        if (empty($operatingHourPatterns) && ! is_array(old('operating_hour_patterns'))) {
            $operatingHourPatterns = [['active_days' => [], 'time_slots' => [['start_time' => '', 'end_time' => '']]]];
        }

        $isEdit = ClinicConfiguration::whereIn('key', [self::KEY_ADDRESS, self::KEY_MONTH_RANGES, self::KEY_HOUR_PATTERNS])
            ->whereNotNull('value')
            ->exists();

        return [
            'isEdit' => $isEdit,
            'direction' => $direction,
            'attentionMonthRanges' => collect($attentionMonthRanges),
            'operatingHourPatterns' => collect($operatingHourPatterns),
            'daysOfWeek' => ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
            'dayKeys' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
            'months' => [
                1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
                7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
            ],
        ];
    }

    public function getClinicInfoForIndex(): array
    {
        $addressValue = ClinicConfiguration::getByKey(self::KEY_ADDRESS, 'No configurada');
        $direction = new \stdClass;
        $direction->direction = $addressValue;

        $attentionMonthRanges = ClinicConfiguration::getByKey(self::KEY_MONTH_RANGES, []);
        $operatingHourPatterns = ClinicConfiguration::getByKey(self::KEY_HOUR_PATTERNS, []);

        $hasConfiguration = ClinicConfiguration::whereIn('key', [self::KEY_ADDRESS, self::KEY_MONTH_RANGES, self::KEY_HOUR_PATTERNS])
            ->whereNotNull('value')
            ->exists();

        return [
            'direction' => $direction,
            'attentionMonthRanges' => $attentionMonthRanges,
            'operatingHourPatterns' => $operatingHourPatterns,
            'monthsTranslation' => [
                1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
            ],
            'daysTranslation' => [
                'monday' => 'Lunes', 'tuesday' => 'Martes', 'wednesday' => 'Miércoles',
                'thursday' => 'Jueves', 'friday' => 'Viernes', 'saturday' => 'Sábado', 'sunday' => 'Domingo',
            ],
            'hasConfiguration' => $hasConfiguration,
        ];
    }

    public function saveClinicInfo(array $validatedData): void
    {
        ClinicConfiguration::setByKey(self::KEY_ADDRESS, $validatedData['direction']);

        $validMonthRanges = array_filter($validatedData['attention_month_ranges'] ?? [], function ($range) {
            return ! empty($range['start_month']) && ! empty($range['end_month']);
        });
        ClinicConfiguration::setByKey(self::KEY_MONTH_RANGES, array_values($validMonthRanges ?: []));

        $validHourPatterns = array_filter($validatedData['operating_hour_patterns'] ?? [], function ($pattern) {
            $hasValidTimeSlots = false;
            if (! empty($pattern['time_slots'])) {
                foreach ($pattern['time_slots'] as $slot) {
                    if (! empty($slot['start_time']) && ! empty($slot['end_time'])) {
                        $hasValidTimeSlots = true;
                        break;
                    }
                }
            }

            return ! empty($pattern['active_days']) || $hasValidTimeSlots;
        });
        ClinicConfiguration::setByKey(self::KEY_HOUR_PATTERNS, array_values($validHourPatterns ?: []));
    }
}
