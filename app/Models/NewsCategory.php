<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'color'];

    public function news()
    {
        return $this->hasMany(News::class);
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
