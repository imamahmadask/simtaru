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
        Schema::table('persyaratan_berkas', function (Blueprint $table) {
            $table->foreignId('tahapan_id')->constrained('tahapans')->onDelete('cascade');
            $table->dropForeign(['layanan_id']);
            $table->dropColumn('layanan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persyaratan_berkas', function (Blueprint $table) {
            $table->dropForeign('tahapan_id');
            $table->foreignId('layanan_id')->constrained('layanan')->onDelete('cascade');
        });
    }
};
