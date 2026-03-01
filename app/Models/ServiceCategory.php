<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'icon'];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('name');
    }

    public function scopeActive($query)
    {
        return $query;
    }
}
