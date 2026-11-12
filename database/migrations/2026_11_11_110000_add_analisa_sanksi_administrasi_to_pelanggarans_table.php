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
        Schema::table('pelanggarans', function (Blueprint $table) {
            $table->string('kategori_pelanggaran')->nullable()->after('jenis_indikasi_pelanggaran');
            $table->string('jenis_pelanggaran')->nullable()->after('kategori_pelanggaran');
            $table->string('dampak_keluhan_masyarakat', 50)->nullable()->after('jenis_pelanggaran');
            $table->string('dampak_radius_wilayah', 50)->nullable()->after('dampak_keluhan_masyarakat');

            $table->foreignId('expert_user_id')->nullable()->after('dampak_radius_wilayah')->constrained('users')->nullOnDelete();
            $table->string('expert_user_name')->nullable()->after('expert_user_id');
            $table->text('expert_justifikasi')->nullable()->after('expert_user_name');
            $table->json('expert_dokumen_pendukung')->nullable()->after('expert_justifikasi');
            $table->text('expert_kesimpulan')->nullable()->after('expert_dokumen_pendukung');
            $table->string('expert_tindakan_rekomendasi', 50)->nullable()->after('expert_kesimpulan');

            $table->string('klasifikasi_pelanggaran', 50)->nullable()->after('expert_tindakan_rekomendasi');

            $table->string('file_pembatalan_kkpr')->nullable()->after('file_sk_sanksi_pemberhentian');
            $table->string('file_pembongkaran_bangunan')->nullable()->after('file_pembatalan_kkpr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggarans', function (Blueprint $table) {
            $table->dropForeign(['expert_user_id']);
            $table->dropColumn([
                'kategori_pelanggaran',
                'jenis_pelanggaran',
                'dampak_keluhan_masyarakat',
                'dampak_radius_wilayah',
                'expert_user_id',
                'expert_user_name',
                'expert_justifikasi',
                'expert_dokumen_pendukung',
                'expert_kesimpulan',
                'expert_tindakan_rekomendasi',
                'klasifikasi_pelanggaran',
                'file_pembatalan_kkpr',
                'file_pembongkaran_bangunan',
            ]);
        });
    }
};
