<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersyaratanBerkas extends Model
{
    protected $table = 'persyaratan_berkas';

    protected $fillable = [
        'nama_berkas',
        'deskripsi',
        'urutan',
        'wajib',
        'tahapan_id',
    ];

    public function tahapan()
    {
        return $this->belongsTo(Layanan::class);
    }
}
