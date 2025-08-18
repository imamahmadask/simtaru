<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tahapan extends Model
{
    protected $table = 'tahapans';

    protected $fillable = [
        'layanan_id',
        'nama',
        'urutan'
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function persyaratanBerkas()
    {
        return $this->hasMany(PersyaratanBerkas::class);
    }
}
