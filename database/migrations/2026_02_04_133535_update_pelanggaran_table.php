<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pelanggarans', function (Blueprint $table) {
            $table->date('tgl_laporan')->nullable()->after('no_pelanggaran');
            $table->string('telp_pelapor', 25)->nullable()->after('nama_pelapor');
            $table->string('no_kkpr_skrk')->nullable();
            $table->string('no_ba_sk_penilaian_kkpr')->nullable();
            $table->string('dokumen_penilaian_kkpr')->nullable();
            $table->string('jenis_pemanfaatan_ruang')->nullable();
            $table->string('tindak_lanjut')->nullable();
            $table->string('dokumen_akhir')->nullable();
            $table->string('foto_tindak_lanjut')->nullable();
            $table->date('tgl_evaluasi')->nullable();
            $table->string('foto_existing')->nullable();

            $table->string('jenis_formulir')->nullable()->change();

            $table->string('tanggal_pengawasan')->nullable()->change();                                   
            $table->text('foto_pengawasan')->nullable()->change();
            $table->string('temuan_pelanggaran')->nullable()->change();
           
            $table->string('bentuk_laporan')->nullable()->change();
            $table->string('nama_pelapor')->nullable()->change();
            $table->string('isi_laporan')->nullable()->change();

            $table->dropColumn('lokasi_pengawasan');
            $table->dropColumn('hasil_pengawasan');
            $table->dropColumn('anggota_tidak_hadir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggarans', function (Blueprint $table) {
            $table->dropColumn('tgl_laporan');
            $table->dropColumn('telp_pelapor');            
            $table->dropColumn('no_kkpr_skrk');
            $table->dropColumn('no_ba_sk_penilaian_kkpr');
            $table->dropColumn('dokumen_penilaian_kkpr');
            $table->dropColumn('jenis_pemanfaatan_ruang');
            $table->dropColumn('tindak_lanjut');
            $table->dropColumn('dokumen_akhir');
            $table->dropColumn('foto_tindak_lanjut');
            $table->dropColumn('tgl_evaluasi');
            $table->dropColumn('foto_existing');    

            $table->string('lokasi_pengawasan')->nullable();
            $table->text('hasil_pengawasan')->nullable();
            $table->string('anggota_tidak_hadir')->nullable();


        });
    }
};
