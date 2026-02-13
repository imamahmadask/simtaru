<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $table = 'pelanggarans';

    protected $fillable = [
        'no_pelanggaran',
        'tgl_laporan',
        'jenis_formulir',
        'tanggal_pengawasan',        
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
        'telp_pelapor',
        'isi_laporan',
        'jenis_indikasi_pelanggaran',
        'status',
        'no_kkpr_skrk',
        'no_ba_sk_penilaian_kkpr',
        'dokumen_penilaian_kkpr',
        'jenis_pemanfaatan_ruang',
        'tgl_evaluasi',
        'tindak_lanjut',
        'dokumen_akhir',
        'foto_tindak_lanjut',
        'foto_existing',
        'penjelasan_singkat',
        'file_sp1',
        'file_sp2',
        'file_sp3',
        'file_pelimpahan_polpp',
        'file_pernyataan',
        'file_sosialisasi',
        'file_ba_pengambilan_dokumen',
        'file_ba_penolakan',
        'file_ba_survey',
        'file_ba_survey_surveyor',
        'file_ba_wawancara',
        'file_ba_penerapan_sanksi',
        'file_ba_sosialisasi',
        'file_sk_sanksi_pemberhentian',
    ];

    protected $casts = [
        'foto_pengawasan' => 'array',
        'foto_existing' => 'array',
        'foto_tindak_lanjut' => 'array',
    ];

    public function sarans()
    {
        return $this->hasMany(SaranPelanggaran::class, 'pelanggaran_id');
    }
}
