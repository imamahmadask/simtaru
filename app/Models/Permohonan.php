<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    protected $table = 'permohonan';

    protected $fillable = [
        'registrasi_id',
        'layanan_id',
        'alamat_tanah',
        'kel_tanah',
        'kec_tanah',
        'jenis_bangunan',
        'status',
        'keterangan',
        'created_by',
        'updated_by',
        'alamat_pemohon',
        'email',
        'npwp',
        'luas_tanah',
        'tgl_selesai',
        'berkas_ktp',
        'berkas_nib',
        'berkas_penguasaan',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function registrasi()
    {
        return $this->belongsTo(Registrasi::class);
    }

    public function berkas()
    {
        return $this->hasMany(PermohonanBerkas::class);
    }

    public function disposisi()
    {
        return $this->hasMany(Disposisi::class);
    }

    public function skrk() {
        return $this->hasMany(Skrk::class);
    }
}
