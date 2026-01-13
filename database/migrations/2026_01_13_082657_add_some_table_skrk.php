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
            $table->string('status_jalan')->nullable();
            $table->string('fungsi_jalan')->nullable();
            $table->string('tipe_jalan')->nullable();
            $table->string('median_jalan')->nullable();
            $table->string('lebar_jalan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skrk', function (Blueprint $table) {
            $table->dropColumn('status_jalan');
            $table->dropColumn('fungsi_jalan');
            $table->dropColumn('tipe_jalan');
            $table->dropColumn('median_jalan');
            $table->dropColumn('lebar_jalan');
        });
    }
};
