<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'icon', 'description', 'order', 'is_active'];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
