<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'day_order',
        'open_time',
        'close_time',
        'break_start',
        'break_end',
        'is_closed'
    ];

    protected $casts = [
        'is_closed' => 'boolean',
        'open_time' => 'datetime:H:i',
        'close_time' => 'datetime:H:i',
        'break_start' => 'datetime:H:i',
        'break_end' => 'datetime:H:i',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('day_order');
    }
}
