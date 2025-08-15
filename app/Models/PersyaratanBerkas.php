<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersyaratanBerkas extends Model
{
    protected $table = 'persyaratan_berkas';

    protected $fillable = [
        'layanan_id',
        'nama_berkas',
        'deskripsi',
        'urutan',
        'wajib',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
}
