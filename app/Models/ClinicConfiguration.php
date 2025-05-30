<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicConfiguration extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    protected array $jsonValueKeys = [
        'attention_month_ranges',
        'operating_hour_patterns',
    ];

    public function getValueAttribute($originalValue): mixed
    {
        if (in_array($this->attributes['key'], $this->jsonValueKeys)) {
            $decoded = json_decode($originalValue, true);

            return (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : ($originalValue === null ? [] : $originalValue);
        }

        return $originalValue; // Para claves no JSON, retorna el string tal cual.
    }

    public function setValueAttribute($inputValue): void
    {
        if (in_array($this->attributes['key'], $this->jsonValueKeys) && (is_array($inputValue) || is_object($inputValue))) {
            $this->attributes['value'] = json_encode($inputValue);
        } else {
            $this->attributes['value'] = $inputValue;
        }
    }

    public static function getByKey(string $key, $default = null): mixed
    {
        $config = static::where('key', $key)->first();

        return $config ? $config->value : $default;
    }

    public static function setByKey(string $key, $value): static
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
