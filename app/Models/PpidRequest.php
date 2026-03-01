<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PpidRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'type',
        'reference_number',
        'name',
        'nik',
        'phone',
        'email',
        'address',
        'occupation',
        'information_type',
        'information_detail',
        'purpose',
        'method',
        'status',
        'is_read',
        'response',
        'response_file',
        'responded_at',
        'responded_by'
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'is_read' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($request) {
            if (empty($request->ticket_number)) {
                $request->ticket_number = 'PPID-' . date('Ymd') . '-' . strtoupper(Str::random(5));
            }
        });
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu',
            'processing' => 'Diproses',
            'completed' => 'Selesai',
            'rejected' => 'Ditolak',
        ];
        return $labels[$this->status] ?? $this->status;
    }
}
