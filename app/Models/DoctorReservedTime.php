<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorReservedTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'details',
        'user_id',
        'office_id',
    ];

    public function casts()
    {
        return [
            'date' => 'string',
        ];
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }
}
