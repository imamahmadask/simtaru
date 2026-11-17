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
            $table->text('jenis_pelanggaran')->nullable()->change();
            $table->string('skala_pelanggaran', 100)->nullable()->after('dampak_radius_wilayah');
            $table->string('riwayat_pelanggaran', 100)->nullable()->after('skala_pelanggaran');
            $table->decimal('nilai_a', 6, 2)->nullable()->after('riwayat_pelanggaran');
            $table->unsignedTinyInteger('nilai_b')->nullable()->after('nilai_a');
            $table->unsignedTinyInteger('nilai_c')->nullable()->after('nilai_b');
            $table->unsignedTinyInteger('nilai_d')->nullable()->after('nilai_c');
            $table->decimal('skor_total', 6, 2)->nullable()->after('nilai_d');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggarans', function (Blueprint $table) {
            $table->dropColumn([
                'skala_pelanggaran',
                'riwayat_pelanggaran',
                'nilai_a',
                'nilai_b',
                'nilai_c',
                'nilai_d',
                'skor_total',
            ]);
            $table->string('jenis_pelanggaran')->nullable()->change();
        });
    }
};
