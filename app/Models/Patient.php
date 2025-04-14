<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surnames',
        'birthdate',
        'email',
        'phone',
        'dni',
        'birthdate',
    ];

    protected function casts()
    {
        return [
            'birthdate' => 'string',
        ];
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
