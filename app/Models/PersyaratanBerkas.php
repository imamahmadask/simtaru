<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersyaratanBerkas extends Model
{
    protected $table = 'persyaratan_berkas';

    protected $fillable = [
        'nama_berkas',
        'kode',
        'deskripsi',
        'urutan',
        'wajib',
        'tahapan_id',
    ];

    public function tahapan()
    {
        return $this->belongsTo(Tahapan::class);
    }

    public function permohonan_berkas()
    {
        return $this->hasOne(PermohonanBerkas::class);
    }
}
