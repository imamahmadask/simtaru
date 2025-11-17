<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanan';

    protected $fillable = ['nama', 'kode', 'keterangan'];

    public function registrasi()
    {
        return $this->hasMany(Registrasi::class);
    }

    public function permohonan()
    {
        return $this->hasMany(Permohonan::class);
    }

    public function tahapan()
    {
        return $this->hasMany(Tahapan::class)->orderBy('urutan', 'asc');
    }

    public function persyaratanBerkas()
    {
        return $this->hasManyThrough(PersyaratanBerkas::class, Tahapan::class);
    }

    public function skrk()
    {
        return $this->hasMany(Skrk::class);
    }

}
