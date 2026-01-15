<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saran extends Model
{
    protected $table = 'sarans';

    protected $fillable = [
        'permohonan_id',
        'nama',
        'pesan',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }
}
