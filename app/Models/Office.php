<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'abbreviation',
        'status',
        'user_id',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
