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
            $table->string('pola_ruang')->nullable();
        });

        Schema::table('itr', function (Blueprint $table) {
            $table->string('pola_ruang')->nullable();
        });

        Schema::table('kkprb', function (Blueprint $table) {
            $table->string('pola_ruang')->nullable();
        });

        Schema::table('kkprnb', function (Blueprint $table) {
            $table->string('pola_ruang')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skrk', function (Blueprint $table) {
            $table->dropColumn('pola_ruang');
        });

        Schema::table('itr', function (Blueprint $table) {
            $table->dropColumn('pola_ruang');
        });

        Schema::table('kkprb', function (Blueprint $table) {
            $table->dropColumn('pola_ruang');
        });

        Schema::table('kkprnb', function (Blueprint $table) {
            $table->dropColumn('pola_ruang');
        });
    }
};
