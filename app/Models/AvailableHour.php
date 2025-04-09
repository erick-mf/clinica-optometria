<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'available_date_id',
    ];

    public function availableDate()
    {
        return $this->belongsTo(AvailableDate::class);
    }

    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }
}
