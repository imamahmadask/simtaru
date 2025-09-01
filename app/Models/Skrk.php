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
        'persyaratan_pelaksanaan'
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
}
