<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    protected $table = 'disposisis';

    protected $fillable = [
        'permohonan_id',
        'tahapan_id',
        'pemberi_id',
        'penerima_id',
        'catatan',
        'tanggal_disposisi',
        'updated_by',
        'layanan_id',
        'layanan_type',
        'is_done',
        'tgl_selesai',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function tahapan()
    {
        return $this->belongsTo(Tahapan::class);
    }

    public function pemberi()
    {
        return $this->belongsTo(User::class, 'pemberi_id');
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'penerima_id');
    }

    public function layanan()
    {
        return $this->morphTo();
    }

    public function getLayananTypeNameAttribute()
    {
        return class_basename($this->layanan_type);
    }
}
