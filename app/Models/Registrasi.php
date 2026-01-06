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
        'email',
        'fungsi_bangunan',
        'alamat_tanah',
        'kel_tanah',
        'kec_tanah',
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

    // Registrasi bisa punya banyak skrk melalui permohonan
    public function skrk()
    {
        return $this->hasManyThrough(
            Skrk::class,        // Model tujuan
            Permohonan::class,  // Model perantara
            'registrasi_id',    // FK di tabel permohonans yang mengacu ke registrasi
            'permohonan_id',    // FK di tabel skrks yang mengacu ke permohonan
            'id',               // PK di tabel registrasis
            'id'                // PK di tabel permohonans
        );
    }
    
    public function itr()
    {
        return $this->hasManyThrough(
            Itr::class,        // Model tujuan
            Permohonan::class,  // Model perantara
            'registrasi_id',    // FK di tabel permohonans yang mengacu ke registrasi
            'permohonan_id',    // FK di tabel itr yang mengacu ke permohonan
            'id',               // PK di tabel registrasis
            'id'                // PK di tabel permohonans
        );
    }
    
    public function kkprb()
    {
        return $this->hasManyThrough(
            Kkprb::class,        // Model tujuan
            Permohonan::class,  // Model perantara
            'registrasi_id',    // FK di tabel permohonans yang mengacu ke registrasi
            'permohonan_id',    // FK di tabel kkprb yang mengacu ke permohonan
            'id',               // PK di tabel registrasis
            'id'                // PK di tabel permohonans
        );
    }
    
    public function kkprnb()
    {
        return $this->hasManyThrough(
            Kkprnb::class,        // Model tujuan
            Permohonan::class,  // Model perantara
            'registrasi_id',    // FK di tabel permohonans yang mengacu ke registrasi
            'permohonan_id',    // FK di tabel kkprnb yang mengacu ke permohonan
            'id',               // PK di tabel registrasis
            'id'                // PK di tabel permohonans
        );
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
