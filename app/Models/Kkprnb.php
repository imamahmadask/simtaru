<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kkprnb extends Model
{
    protected $table = 'kkprnb';
    protected $fillable = [
        'permohonan_id',
        'layanan_id',
        'jenis_kegiatan',
        'tgl_validasi',
        'tgl_ptp',
        'tgl_terima_ptp',
        'no_ptp',
        'berkas_ptp',
        'tgl_survey',
        'batas_persil',
        'status_jalan',
        'fungsi_jalan',
        'tipe_jalan',
        'median_jalan',
        'lebar_jalan',
        'koordinat',
        'ada_bangunan',
        'gambar_peta',
        'foto_survey',
        'is_survey',
        'is_berkas_survey_uploaded',
        'rdtr_rtrw',
        'penguasaan_tanah',
        'jml_bangunan',
        'jml_lantai',
        'luas_lantai',
        'luas_disetujui',
        'kedalaman_min',
        'kedalaman_max',
        'indikasi_program',
        'kdb',
        'klb',
        'gsb',
        'jba',
        'jbb',
        'kdh',
        'ktb',
        'jaringan_utilitas',
        'persyaratan_pelaksanaan',
        'kesimpulan',
        'is_kajian',
        'is_berkas_analis_uploaded',
        'is_analis',
        'is_validate',
        'tgl_validate',
        'tanggapan_1a',
        'tanggapan_1b',
        'tanggapan_2',
        'ceklis',
        'surat_pengantar_kelengkapan',
        'akta_pendirian',
        'gambar_teknis'
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
