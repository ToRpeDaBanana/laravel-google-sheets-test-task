<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'status'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('allowed', function ($query) {
            $query->where('status', 'Allowed');
        });
    }

    public function scopeAllowed($query)
    {
        return $query->where('status', 'Allowed');
    }
}
