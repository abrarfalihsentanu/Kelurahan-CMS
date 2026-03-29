<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function scopeForInfographic($query)
    {
        return $query->where('type', 'infographic');
    }

    public function scopeForPotential($query)
    {
        return $query->where('type', 'potential');
    }

    public function infographics()
    {
        return $this->hasMany(Infographic::class);
    }

    public function potentials()
    {
        return $this->hasMany(Potential::class);
    }
}
