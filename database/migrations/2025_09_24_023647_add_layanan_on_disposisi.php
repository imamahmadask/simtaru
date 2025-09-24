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
            // Kolom spesifik untuk masing-masing layanan
            $table->integer('updated_by')->nullable()->after('tanggal_disposisi');
            $table->morphs('layanan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disposisis', function (Blueprint $table) {
            $table->dropColumn('updated_by');
            $table->dropMorphs('layanan');
        });
    }
};
