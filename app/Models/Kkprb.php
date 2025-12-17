<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kkprb extends Model
{
    protected $table = 'kkprb';
    protected $fillable = [
        'permohonan_id',
        'layanan_id',
        'tgl_oss',
        'oss_id',
        'tgl_validasi',
        'tgl_pnbp',
        'tgl_ptp',
        'no_ptp',
        'berkas_ptp',
        'tgl_survey',
        'id_proyek',
        'batas_persil',
        'koordinat',
        'gambar_peta',
        'foto_survey',
        'is_survey',
        'is_berkas_survey_uploaded',
        'ada_bangunan',
        'skala_usaha',
        'no_kbli',
        'kbli',
        'status_modal',
        'penguasaan_tanah',
        'jml_bangunan',
        'jml_lantai',
        'luas_lantai',
        'kedalaman_min',
        'kedalaman_max',
        'nib',
        'jenis_usaha',
        'indikasi_program',
        'is_kajian',
        'is_berkas_kajian_uploaded',
        'is_analis',
        'is_validate',
        'tgl_validate',
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
