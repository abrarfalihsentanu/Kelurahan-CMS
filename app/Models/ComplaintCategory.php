<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'icon'];

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('name');
    }
}
