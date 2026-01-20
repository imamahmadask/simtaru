<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $table = 'pelanggarans';

    protected $fillable = [
        'no_pelanggaran',
        'jenis_formulir',
        'tanggal_pengawasan',
        'lokasi_pengawasan',
        'hasil_pengawasan',
        'anggota_tidak_hadir',
        'foto_pengawasan',
        'temuan_pelanggaran',
        'sumber_informasi_pelanggaran',
        'nama_pelanggar',
        'alamat_pelanggar',
        'kel_pelanggar',
        'kec_pelanggar',
        'kota_pelanggar',
        'prov_pelanggar',
        'alamat_pelanggaran',
        'kel_pelanggaran',
        'kec_pelanggaran',
        'koordinat_pelanggaran',
        'gmaps_pelanggaran',
        'bentuk_laporan',
        'nama_pelapor',
        'isi_laporan',
        'jenis_indikasi_pelanggaran',
        'status',
    ];
}
