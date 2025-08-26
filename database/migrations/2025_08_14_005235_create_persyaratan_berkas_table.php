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
        Schema::create('persyaratan_berkas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_berkas', 150);
            $table->text('deskripsi')->nullable();
            $table->integer('urutan')->default(1);
            $table->boolean('wajib')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persyaratan_berkas');
    }
};
