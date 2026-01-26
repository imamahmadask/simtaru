<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itr extends Model
{
    protected $table = 'itr';
    protected $fillable = [
        'permohonan_id',
        'layanan_id',
        'jenis_itr',
        'no_kkkpr',
        'dokumen_kkkpr',
        'skala_usaha',
        'luas_disetujui',
        'penguasaan_tanah',
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
        'tgl_survey',
        'koordinat',
        'gambar_peta',
        'foto_survey',
        'is_survey',
        'is_berkas_survey_uploaded',
        'is_analis',
        'is_berkas_analis_uploaded',
        'is_dokumen',
        'is_validate',
        'batas_persil',
        'keterangan',
        'pola_ruang',
        'is_survey_hold',
        'tgl_survey_hold',
        'tgl_survey_unhold',
        'ket_survey_hold',
    ];

    protected $casts = [
        'koordinat' => 'array',
        'batas_persil' => 'array'
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

    public function disposisis()
    {
        return $this->morphMany(Disposisi::class, 'layanan');
    }
}
