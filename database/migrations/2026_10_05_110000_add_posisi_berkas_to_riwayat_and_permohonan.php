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
        Schema::table('riwayat_permohonans', function (Blueprint $table) {
            $table->string('instansi')->nullable()->after('user_id');
            $table->string('proses')->nullable()->after('instansi');
            $table->date('tanggal_status')->nullable()->after('proses');
            $table->text('catatan')->nullable()->after('tanggal_status');
        });

        Schema::table('permohonan', function (Blueprint $table) {
            $table->string('posisi_berkas')->nullable()->after('keterangan');
            $table->string('proses_berkas')->nullable()->after('posisi_berkas');
            $table->date('tgl_posisi_berkas')->nullable()->after('proses_berkas');
            $table->text('ket_posisi_berkas')->nullable()->after('tgl_posisi_berkas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_permohonans', function (Blueprint $table) {
            $table->dropColumn(['instansi', 'proses', 'tanggal_status', 'catatan']);
        });

        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropColumn(['posisi_berkas', 'proses_berkas', 'tgl_posisi_berkas', 'ket_posisi_berkas']);
        });
    }
};
