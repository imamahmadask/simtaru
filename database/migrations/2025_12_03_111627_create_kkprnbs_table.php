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
        Schema::create('kkprnb', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonan')->cascadeOnDelete();
            $table->foreignId('layanan_id')->constrained('layanan')->cascadeOnDelete();
            $table->string('jenis_kkprnb', 100)->nullable();
            $table->date('tgl_validasi')->nullable();
            $table->date('tgl_ptp')->nullable();
            $table->date('tgl_terima_ptp')->nullable();
            $table->string('no_ptp', 50)->nullable();
            $table->string('berkas_ptp')->nullable();
            
            $table->date('tgl_survey')->nullable(); 
            $table->json('batas_persil')->nullable();
            $table->string('status_jalan', 50)->nullable();
            $table->string('fungsi_jalan', 50)->nullable();
            $table->string('tipe_jalan', 50)->nullable();
            $table->string('median_jalan', 50)->nullable();
            $table->string('lebar_jalan', 50)->nullable();
            $table->json('koordinat')->nullable();
            $table->string('ada_bangunan', 50)->nullable();
            $table->string('gambar_peta')->nullable();
            $table->string('foto_survey')->nullable();
            $table->boolean('is_survey')->default(false)->nullable();
            $table->boolean('is_berkas_survey_uploaded')->default(false)->nullable();
            
            $table->string('rdtr_rtrw', 100)->nullable();
            $table->string('penguasaan_tanah', 100)->nullable();
            $table->string('jml_bangunan', 50)->nullable();
            $table->string('jml_lantai', 50)->nullable();
            $table->string('luas_lantai', 50)->nullable();
            $table->string('kedalaman_min', 50)->nullable();
            $table->string('kedalaman_max', 50)->nullable();
            $table->string('indikasi_program')->nullable();
            $table->string('kdb')->nullable();
            $table->string('klb')->nullable();
            $table->string('gsb')->nullable();
            $table->string('jbb')->nullable();
            $table->string('kdh')->nullable();
            $table->string('ktb')->nullable();
            $table->string('jaringan_utilitas')->nullable();
            $table->string('persyaratan_pelaksanaan')->nullable();
            $table->boolean('is_kajian')->default(false)->nullable();
            $table->boolean('is_berkas_kajian_uploaded')->default(false)->nullable();
            $table->boolean('is_analis')->default(false)->nullable();
           
            $table->boolean('is_validate')->default(false)->nullable();   
            $table->date('tgl_validate')->nullable();         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kkprnb');
    }
};
