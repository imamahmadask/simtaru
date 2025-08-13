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
        Schema::create('riwayat_permohonans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registrasi_id');
            $table->integer('user_id');
            $table->string('keterangan')->nullable();
            $table->foreign('registrasi_id')->references('id')->on('registrasi')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_permohonans');
    }
};
