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
        'document_type',
        'document_number',
        'birthdate',
        'tutor_name',
        'tutor_email',
        'tutor_document_type',
        'tutor_document_number',
        'tutor_phone',
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
