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
            $table->text('gmaps_pelanggaran')->nullable()->change();
            $table->text('foto_tindak_lanjut')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggarans', function (Blueprint $table) {
            $table->string('gmaps_pelanggaran')->nullable()->change();
            $table->string('foto_tindak_lanjut')->nullable()->change();
        });
    }
};
