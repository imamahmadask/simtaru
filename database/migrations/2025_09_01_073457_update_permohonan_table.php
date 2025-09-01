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
        Schema::table('permohonan', function (Blueprint $table) {
            $table->string('alamat_pemohon')->nullable();
            $table->string('email', 50)->nullable();
            $table->string('npwp', 50)->nullable();
            $table->string('luas_tanah', 50)->nullable();
            $table->datetime('tgl_selesai')->nullable();

            $table->renameColumn('berkas_pemohon', 'berkas_ktp');
            $table->string('berkas_nib')->nullable();
            $table->string('berkas_penguasaan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropColumn('alamat_pemohon');
            $table->dropColumn('email');
            $table->dropColumn('npwp');
            $table->dropColumn('luas_tanah');
            $table->dropColumn('tgl_selesai');

            $table->renameColumn('berkas_ktp', 'berkas_pemohon');
            $table->dropColumn('berkas_nib');
            $table->dropColumn('berkas_penguasaan');
        });
    }
};
