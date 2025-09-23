<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermohonanBerkas extends Model
{
    protected $table = 'permohonan_berkas';

    protected $fillable =[
        'permohonan_id',
        'persyaratan_berkas_id',
        'file_path',
        'uploaded_by',
        'uploaded_at',
        'status',
        'catatan_verifikator',
        'verified_by',
        'verified_at'
    ];

    public function persyaratan()
    {
        return $this->belongsTo(PersyaratanBerkas::class);
    }

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }
}
