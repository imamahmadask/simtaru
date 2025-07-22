<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    protected $table = 'registrasi';

    protected $fillable = [
        'nama',
        'nik',
        'no_hp',
        'tanggal',
        'layanan_id',
        'created_by',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function permohonan()
    {
        return $this->hasOne(Permohonan::class);
    }
}
