<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'complaint_category_id',
        'name',
        'nik',
        'phone',
        'email',
        'address',
        'rt_rw',
        'subject',
        'description',
        'location',
        'incident_date',
        'attachments',
        'status',
        'is_read',
        'response',
        'responded_at',
        'responded_by'
    ];

    protected $casts = [
        'attachments' => 'array',
        'responded_at' => 'datetime',
        'incident_date' => 'date',
        'is_read' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($complaint) {
            if (empty($complaint->ticket_number)) {
                $year = date('Y');
                $month = date('m');
                // Get the last sequential number for this month
                $lastComplaint = static::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->orderByDesc('id')
                    ->first();

                if ($lastComplaint && preg_match('/-(\d{5})$/', $lastComplaint->ticket_number, $matches)) {
                    $nextNumber = intval($matches[1]) + 1;
                } else {
                    $nextNumber = 1;
                }

                $complaint->ticket_number = 'ADU-' . $year . $month . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(ComplaintCategory::class, 'complaint_category_id');
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Verifikasi',
            'process' => 'Sedang Diproses',
            'resolved' => 'Selesai',
            'rejected' => 'Ditolak',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'process' => 'info',
            'resolved' => 'success',
            'rejected' => 'danger',
        ];
        return $colors[$this->status] ?? 'secondary';
    }
}
