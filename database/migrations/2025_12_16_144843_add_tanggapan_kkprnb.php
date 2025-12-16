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
            $table->string('tanggapan_1a')->nullable();
            $table->string('tanggapan_1b')->nullable();
            $table->string('tanggapan_2')->nullable();
            $table->string('ceklis')->nullable();
            $table->string('surat_pengantar_kelengkapan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kkprnb', function (Blueprint $table) {
            $table->dropColumn('tanggapan_1a');
            $table->dropColumn('tanggapan_1b');
            $table->dropColumn('tanggapan_2');
            $table->dropColumn('ceklis');
            $table->dropColumn('surat_pengantar_kelengkapan');
        });
    }
};
