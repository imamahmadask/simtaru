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
        Schema::create('skrk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonan')->cascadeOnDelete();
            $table->foreignId('layanan_id')->constrained('layanan')->cascadeOnDelete();
            $table->date('tgl_survey')->nullable();
            $table->date('penguasaan_tanah')->nullable();
            $table->string('ada_bangunan', 50)->nullable();
            $table->string('status_modal', 50)->nullable();
            $table->string('kbli', 100)->nullable();
            $table->string('judul_kbli', 100)->nullable();
            $table->string('skala_usaha', 100)->nullable();
            $table->string('koordinat')->nullable();
            $table->string('luas_disetujui', 50)->nullable();
            $table->string('pemanfaatan_ruang', 100)->nullable();
            $table->string('peraturan_zonasi', 100)->nullable();
            $table->string('kbli_diizinkan', 100)->nullable();
            $table->string('kdb', 100)->nullable();
            $table->string('klb', 100)->nullable();
            $table->string('gsb', 100)->nullable();
            $table->string('jba', 100)->nullable();
            $table->string('jbb', 100)->nullable();
            $table->string('kdh', 100)->nullable();
            $table->string('ktb', 100)->nullable();
            $table->string('luas_kavling', 100)->nullable();
            $table->string('jaringan_utilitas', 100)->nullable();
            $table->string('persyaratan_pelaksanaan', 100)->nullable();
            $table->string('gambar_peta')->nullable();
            $table->string('foto_survey')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skrk');
    }
};
