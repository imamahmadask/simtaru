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
        Schema::create('pelanggarans', function (Blueprint $table) {
            $table->id();
            $table->string('no_pelanggaran');
            $table->string('jenis_formulir');

            $table->string('tanggal_pengawasan');            
            $table->string('lokasi_pengawasan');            
            $table->text('hasil_pengawasan');            
            $table->string('anggota_tidak_hadir');            
            $table->text('foto_pengawasan');
            $table->string('temuan_pelanggaran');

            $table->string('sumber_informasi_pelanggaran');
            $table->string('nama_pelanggar');
            $table->string('alamat_pelanggar');
            $table->string('kel_pelanggar');
            $table->string('kec_pelanggar');
            $table->string('kota_pelanggar');
            $table->string('prov_pelanggar');

            $table->string('alamat_pelanggaran');
            $table->string('kel_pelanggaran');
            $table->string('kec_pelanggaran');
            $table->string('koordinat_pelanggaran');
            $table->string('gmaps_pelanggaran');

            $table->string('bentuk_laporan');
            $table->string('nama_pelapor');
            $table->string('isi_laporan');

            $table->string('jenis_indikasi_pelanggaran');
            $table->string('status');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggarans');
    }
};
