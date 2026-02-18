<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaranPenilaian extends Model
{
    protected $fillable = [
        'penilaian_id',
        'nama',
        'pesan',
    ];

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class);
    }
}
