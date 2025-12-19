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
        Schema::table('kkprnb', function (Blueprint $table) {
            $table->string('luas_disetujui')->nullable()->after('luas_lantai');
            $table->renameColumn('jenis_kkprnb', 'jenis_kegiatan');         
            $table->string('kesimpulan')->nullable();     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kkprnb', function (Blueprint $table) {
            $table->dropColumn('luas_disetujui');
            $table->renameColumn('jenis_kegiatan', 'jenis_kkprnb');
            $table->dropColumn('kesimpulan');
        });
    }
};
