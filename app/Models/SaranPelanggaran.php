<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaranPelanggaran extends Model
{
    protected $fillable = [
        'pelanggaran_id',
        'nama',
        'pesan',
    ];

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class);
    }
}
