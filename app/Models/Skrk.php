<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skrk extends Model
{
    protected $table = 'skrk';

    protected $fillable = [
        'permohonan_id',
        'layanan_id',
        'tgl_survey',
        'penguasaan_tanah',
        'ada_bangunan',
        'status_modal',
        'kbli',
        'judul_kbli',
        'skala_usaha',
        'koordinat',
        'luas_disetujui',
        'pemanfaatan_ruang',
        'peraturan_zonasi',
        'kbli_diizinkan',
        'kdb',
        'klb',
        'gsb',
        'jba',
        'jbb',
        'kdh',
        'ktb',
        'luas_kavling',
        'jaringan_utilitas',
        'persyaratan_pelaksanaan',
        'gambar_peta',
        'foto_survey',
        'jml_bangunan',
        'jml_lantai',
        'luas_lantai',
        'kedalaman_min',
        'kedalaman_max'
    ];

    protected $casts = [
        'koordinat' => 'array',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
    public function registrasi()
    {
        return $this->hasOneThrough(
            Registrasi::class,   // Model tujuan
            Permohonan::class,   // Model perantara
            'id',                // FK di tabel permohonans (id permohonan)
            'id',                // FK di tabel registrasis
            'permohonan_id',     // FK di tabel skrks
            'registrasi_id'      // FK di tabel permohonans
        );
    }
}
