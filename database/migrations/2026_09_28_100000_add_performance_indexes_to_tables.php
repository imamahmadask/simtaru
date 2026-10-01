<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Daftar index performa per tabel: [nama_index => kolom_atau_array_kolom]
     */
    private array $indexes = [
        'registrasi' => [
            'idx_registrasi_layanan_id' => 'layanan_id',
            'idx_registrasi_status' => 'status',
            'idx_registrasi_tanggal' => 'tanggal',
            'idx_registrasi_created_at' => 'created_at',
            'idx_registrasi_nama' => 'nama',
        ],
        'permohonan' => [
            'idx_permohonan_status' => 'status',
            'idx_permohonan_prioritas_created' => ['is_prioritas', 'created_at'],
            'idx_permohonan_done_created' => ['is_done', 'created_at'],
            'idx_permohonan_ditolak' => 'is_ditolak',
        ],
        'permohonan_berkas' => [
            'idx_pberkas_permohonan_versi_status' => ['permohonan_id', 'versi', 'status'],
            'idx_pberkas_permohonan_persyaratan_versi' => ['permohonan_id', 'persyaratan_berkas_id', 'versi'],
        ],
        'disposisis' => [
            'idx_disposisis_penerima_done' => ['penerima_id', 'is_done'],
            'idx_disposisis_permohonan_tahapan_status' => ['permohonan_id', 'tahapan_id', 'status'],
            'idx_disposisis_tanggal' => 'tanggal_disposisi',
        ],
        'riwayat_permohonans' => [
            'idx_riwayat_permohonans_user_id' => 'user_id',
        ],
        'pelanggarans' => [
            'idx_pelanggarans_tgl_laporan' => 'tgl_laporan',
            'idx_pelanggarans_status' => 'status',
            'idx_pelanggarans_temuan' => 'temuan_pelanggaran',
            'idx_pelanggarans_sumber' => 'sumber_informasi_pelanggaran',
            'idx_pelanggarans_jenis' => 'jenis_indikasi_pelanggaran',
            'idx_pelanggarans_tindak_lanjut' => 'tindak_lanjut',
            'idx_pelanggarans_kec' => 'kec_pelanggaran',
        ],
        'penilaians' => [
            'idx_penilaians_tanggal' => 'tanggal_penilaian',
            'idx_penilaians_jenis' => 'jenis_penilaian',
            'idx_penilaians_status' => 'status',
        ],
        'users' => [
            'idx_users_role' => 'role',
        ],
        'layanan' => [
            'idx_layanan_kode' => 'kode',
        ],
        'persyaratan_berkas' => [
            'idx_persyaratan_berkas_kode' => 'kode',
        ],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->indexes as $tableName => $tableIndexes) {
            if (!Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName, $tableIndexes) {
                foreach ($tableIndexes as $indexName => $columns) {
                    if (!Schema::hasIndex($tableName, $indexName)) {
                        $table->index($columns, $indexName);
                    }
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->indexes as $tableName => $tableIndexes) {
            if (!Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName, $tableIndexes) {
                foreach (array_keys($tableIndexes) as $indexName) {
                    if (Schema::hasIndex($tableName, $indexName)) {
                        $table->dropIndex($indexName);
                    }
                }
            });
        }
    }
};
