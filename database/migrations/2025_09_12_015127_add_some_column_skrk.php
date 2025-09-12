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
        Schema::table('skrk', function (Blueprint $table) {
            $table->string('jml_bangunan', 50)->nullable();
            $table->string('jml_lantai', 50)->nullable();
            $table->string('luas_lantai', 50)->nullable();
            $table->string('kedalaman_min', 50)->nullable();
            $table->string('kedalaman_max', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skrk', function (Blueprint $table) {
            $table->dropColumn('jml_bangunan');
            $table->dropColumn('jml_lantai');
            $table->dropColumn('luas_lantai');
            $table->dropColumn('kedalaman_min');
            $table->dropColumn('kedalaman_max');
        });
    }
};
