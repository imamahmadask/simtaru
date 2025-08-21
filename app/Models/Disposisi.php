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
        'tanggal_disposisi'
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function tahapan()
    {
        return $this->belongsTo(Tahapan::class);
    }

}
