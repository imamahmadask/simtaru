<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPermohonan extends Model
{
    protected $table = 'riwayat_permohonans';

    protected $fillable = [
        'permohonan_id',
        'user_id',
        'status',
        'keterangan',
        'file',
        'permohonan_id'
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
