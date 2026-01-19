<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'images',
        'category',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d F Y');
    }
}
