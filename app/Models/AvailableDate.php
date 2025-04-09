<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableDate extends Model
{
    use HasFactory;

    protected $fillable = ['date'];

    protected function casts()
    {
        return [
            'date' => 'string',
        ];
    }

    public function hours()
    {
        return $this->hasMany(AvailableHour::class);
    }
}
