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
            $table->string('nama_pelanggar')->nullable()->change();
            $table->text('pasal_aturan_dilanggar')->nullable()->after('penjelasan_singkat');
            $table->text('penjelasan_lainnya')->nullable()->after('pasal_aturan_dilanggar');
            $table->json('peta_deliniasi')->nullable()->after('foto_existing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggarans', function (Blueprint $table) {
            $table->dropColumn([
                'pasal_aturan_dilanggar',
                'penjelasan_lainnya',
                'peta_deliniasi',
            ]);
        });
    }
};
