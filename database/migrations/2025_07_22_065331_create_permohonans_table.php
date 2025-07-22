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
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registrasi_id');
            $table->unsignedBigInteger('layanan_id');
            $table->string('alamat_tanah');
            $table->string('kel_tanah');
            $table->string('kec_tanah');
            $table->string('jenis_bangunan');
            $table->string('status');
            $table->string('keterangan')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->foreign('registrasi_id')->references('id')->on('registrasi')->onDelete('cascade');
            $table->foreign('layanan_id')->references('id')->on('layanan')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan');
    }
};
