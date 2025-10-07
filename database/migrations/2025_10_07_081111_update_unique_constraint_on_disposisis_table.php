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
        Schema::table('disposisis', function (Blueprint $table) {
            // Tambahkan kolom is_done jika belum ada
            if (!Schema::hasColumn('disposisis', 'is_done')) {
                $table->boolean('is_done')->default(false)->after('catatan');
            }

            // Hapus unique constraint lama
            $table->dropUnique(['permohonan_id', 'tahapan_id']);

            // Tambahkan unique constraint baru dengan is_done
            $table->unique(['permohonan_id', 'tahapan_id', 'is_done'], 'disposisis_permohonan_tahapan_isdone_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disposisis', function (Blueprint $table) {
            // Hapus unique constraint baru
            $table->dropUnique('disposisis_permohonan_tahapan_isdone_unique');

            // Kembalikan ke unique lama
            $table->unique(['permohonan_id', 'tahapan_id']);

            // (Opsional) hapus kolom is_done jika tidak ingin dipertahankan
            // $table->dropColumn('is_done');
        });
    }
};
