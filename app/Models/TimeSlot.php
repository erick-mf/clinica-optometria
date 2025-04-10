<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'available_hour_id',
        'is_available',
    ];

    public function casts()
    {
        return [
            'is_available' => 'boolean',
        ];
    }

    public function availableHour()
    {
        return $this->belongsTo(AvailableHour::class);
    }
}
