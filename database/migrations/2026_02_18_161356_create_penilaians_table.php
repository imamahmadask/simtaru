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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_penilaian')->nullable();
            $table->string('jenis_penilaian')->nullable();
            $table->string('jenis_dokumen')->nullable();
            $table->string('nomor_dokumen')->nullable();
            $table->string('nama_pelaku_usaha')->nullable();
            $table->text('alamat_pelaku_usaha')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('file_dokumen')->nullable();
            $table->string('nama_usaha')->nullable();
            $table->text('alamat_lokasi_usaha')->nullable();
            $table->string('jenis_kegiatan_usaha')->nullable();
            $table->string('koordinat')->nullable();
            $table->text('analisa_penilaian')->nullable();
            $table->text('rekomendasi')->nullable();
            $table->string('link_hasil_penilaian')->nullable();
            $table->string('status')->default('Selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
