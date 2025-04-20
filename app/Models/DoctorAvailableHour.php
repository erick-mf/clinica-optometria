<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAvailableHour extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_id', 'available_hour_id'];

    public function availableHour()
    {
        return $this->belongsTo(AvailableHour::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class);
    }
}
