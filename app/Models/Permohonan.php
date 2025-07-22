<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    protected $table = 'permohonan';

    protected $fillable = [
        'registrasi_id',
        'layanan_id',
        'alamat_tanah',
        'kel_tanah',
        'kec_tanah',
        'jenis_bangunan',
        'status',
        'keterangan',
        'created_by',
        'edited_by'
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function registrasi()
    {
        return $this->belongsTo(Registrasi::class);
    }
}
