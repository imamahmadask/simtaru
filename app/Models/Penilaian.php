<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = [
        'tanggal_penilaian',
        'jenis_penilaian',
        'jenis_dokumen',
        'nomor_dokumen',
        'nama_pelaku_usaha',
        'alamat_pelaku_usaha',
        'no_telepon',
        'email',
        'file_dokumen',
        'nama_usaha',
        'alamat_lokasi_usaha',
        'jenis_kegiatan_usaha',
        'koordinat',
        'analisa_penilaian',
        'rekomendasi',
        'link_hasil_penilaian',
        'status',
    ];
    public function sarans()
    {
        return $this->hasMany(SaranPenilaian::class, 'penilaian_id');
    }
}
