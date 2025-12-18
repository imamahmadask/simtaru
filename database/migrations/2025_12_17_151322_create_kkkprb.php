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
        Schema::create('kkprb', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonan')->cascadeOnDelete();
            $table->foreignId('layanan_id')->constrained('layanan')->cascadeOnDelete();            
            $table->date('tgl_validasi')->nullable();
            $table->date('tgl_pnbp')->nullable();
            $table->date('tgl_ptp')->nullable();
            $table->string('no_ptp', 50)->nullable();
            $table->string('berkas_ptp')->nullable();

            $table->date('tgl_survey')->nullable();               
            $table->string('ada_bangunan')->nullable();                       
            $table->string('nama_pelaku_usaha')->nullable();              
            $table->json('batas_persil')->nullable();            
            $table->json('koordinat')->nullable();
            $table->string('status_jalan', 50)->nullable();
            $table->string('fungsi_jalan', 50)->nullable();
            $table->string('tipe_jalan', 50)->nullable();
            $table->string('median_jalan', 50)->nullable();
            $table->string('lebar_jalan', 50)->nullable();
            $table->string('gambar_peta')->nullable();
            $table->string('foto_survey')->nullable();
            $table->boolean('is_survey')->default(false)->nullable();
            $table->boolean('is_berkas_survey_uploaded')->default(false)->nullable();
            
            $table->date('tgl_oss')->nullable();
            $table->string('oss_id')->nullable();
            $table->string('id_proyek')->nullable(); 
            $table->string('skala_usaha')->nullable();
            $table->string('jenis_usaha')->nullable();
            $table->string('penguasaan_tanah')->nullable();
            $table->string('jml_bangunan')->nullable();
            $table->string('jml_lantai')->nullable();
            $table->string('luas_lantai')->nullable();
            $table->string('kedalaman_min')->nullable();
            $table->string('kedalaman_max')->nullable();
            $table->string('nib')->nullable();
            $table->string('indikasi_program')->nullable();
            $table->string('kdb')->nullable();
            $table->string('klb')->nullable();
            $table->string('kdh')->nullable();
            $table->string('gsb')->nullable();
            $table->string('luas_disetujui')->nullable();
            $table->string('no_nota_dinas')->nullable();
            $table->date('tgl_nota_dinas')->nullable();
            $table->boolean('is_kajian')->default(false)->nullable();
            $table->boolean('is_berkas_analis_uploaded')->default(false)->nullable();
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
        Schema::dropIfExists('kkprb');
    }
};
