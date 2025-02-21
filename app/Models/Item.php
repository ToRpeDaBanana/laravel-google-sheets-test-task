<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\GoogleSheetService;

class Item extends Model
{
    use HasFactory;
    
    protected $fillable = ['name','description', 'status'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($item) {
            $item->syncToGoogleSheet();
        });

        static::updated(function ($item) {
            $item->syncToGoogleSheet();
        });

        static::deleted(function ($item) {
            $item->syncToGoogleSheet();
        });
    }
    public function scopeAllowed($query)
    {
        return $query->where('status', 'Allowed');
    }

    protected static function syncToGoogleSheet()
    {
        $service = new GoogleSheetService();
        $service->syncData();
    }
}
