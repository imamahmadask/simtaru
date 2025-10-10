<?php

namespace App\Models;

use App\Models\User;
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
        'verified_at',
        'versi'
    ];

    public function persyaratan()
    {
        return $this->belongsTo(PersyaratanBerkas::class, 'persyaratan_berkas_id');
    }

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getFileNameAttribute()
    {
        return basename($this->file_path);
    }

}
