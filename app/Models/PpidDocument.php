<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpidDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'ppid_category_id',
        'title',
        'description',
        'file',
        'file_type',
        'file_size',
        'year',
        'downloads',
        'order',
        'is_published'
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(PpidCategory::class, 'ppid_category_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('order');
    }

    public function incrementDownloads()
    {
        $this->increment('downloads');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
