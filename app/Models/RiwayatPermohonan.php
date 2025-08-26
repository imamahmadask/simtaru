<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPermohonan extends Model
{
    protected $table = 'riwayat_permohonans';

    protected $fillable = [
        'registrasi_id',
        'user_id',
        'keterangan',
    ];

    public function registrasi()
    {
        return $this->belongsTo(Registrasi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('orderByCreatedAt', function ($builder) {
            $builder->orderBy('created_at', 'desc')->orderBy('id', 'desc');
        });
    }
}
