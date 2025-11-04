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
        Schema::create('itr', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonan')->cascadeOnDelete();
            $table->foreignId('layanan_id')->constrained('layanan')->cascadeOnDelete();
            $table->string('penguasaan_tanah', 100)->nullable();
            $table->string('pemanfaatan_ruang', 100)->nullable();
            $table->string('peraturan_zonasi', 100)->nullable();
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
            $table->date('tgl_survey')->nullable();
            $table->string('koordinat')->nullable();
            $table->string('gambar_peta')->nullable();
            $table->string('foto_survey')->nullable();
            $table->boolean('is_survey')->nullable();
            $table->boolean('is_berkas_survey_uploaded')->nullable();
            $table->boolean('is_kajian')->nullable();
            $table->boolean('is_analis')->nullable();
            $table->boolean('is_berkas_analis_uploaded')->nullable();
            $table->boolean('is_dokumen')->nullable();
            $table->boolean('is_validate')->nullable();
            $table->json('batas_persil')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itr');
    }
};
