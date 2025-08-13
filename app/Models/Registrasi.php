<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    protected $table = 'registrasi';

    protected $fillable = [
        'kode',
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

    public function riwayat()
    {
        return $this->hasMany(RiwayatPermohonan::class);
    }
}
