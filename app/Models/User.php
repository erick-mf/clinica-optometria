<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'surnames',
        'phone',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function availableHours()
    {
        return $this->hasMany(DoctorAvailableHour::class, 'doctor_id');
    }

    public function hours()
    {
        return $this->belongsToMany(AvailableHour::class, 'doctor_available_hours', 'doctor_id', 'available_hour_id');
    }

    public function office()
    {
        return $this->hasOne(Office::class, 'user_id');
    }

    public function personalReservations()
    {
        return $this->hasMany(DoctorReservedTime::class, 'user_id');
    }
}
