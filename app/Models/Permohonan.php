<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    protected $table = 'permohonan';

    protected $fillable = [
        'registrasi_id',
        'layanan_id',
        'status',
        'keterangan',
        'created_by',
        'updated_by',
        'alamat_pemohon',
        'npwp',
        'luas_tanah',
        'no_dokumen',
        'waktu_pengerjaan',
        'tgl_selesai',
        'berkas_ktp',
        'berkas_nib',
        'berkas_penguasaan',
        'berkas_permohonan',
        'is_prioritas',
        'status_modal',
        'kbli',
        'judul_kbli',
        'berkas_kuasa',
        'is_done'
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

    public function kkprnb() {
        return $this->hasMany(Kkprnb::class);
    }

    public function kkprb() {
        return $this->hasMany(Kkprb::class);
    }

    public function itr() {
        return $this->hasMany(Itr::class);
    }

    public function persyaratanBerkas()
    {
        return $this->hasManyThrough(
            PersyaratanBerkas::class,
            Tahapan::class,
            'layanan_id',       // foreign key di tabel tahapan
            'tahapan_id',       // foreign key di tabel persyaratan_berkas
            'layanan_id',       // foreign key di tabel permohonan
            'id'                // local key di tabel tahapan
        );
    }
}
