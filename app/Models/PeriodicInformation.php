<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodicInformation extends Model
{
    use HasFactory;

    protected $table = 'periodic_informations';

    protected $fillable = [
        'title',
        'description',
        'content',
        'file',
        'file_type',
        'file_size',
        'category',
        'year',
        'downloads',
        'order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function incrementDownloads()
    {
        $this->increment('downloads');
    }
}
