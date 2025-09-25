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
        Schema::table('registrasi', function (Blueprint $table) {
            $table->string('fungsi_bangunan', 50)->nullable();
            $table->string('alamat_tanah')->nullable();
            $table->string('kel_tanah', 50)->nullable();
            $table->string('kec_tanah', 50)->nullable();
        });

        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropColumn('jenis_bangunan');
            $table->dropColumn('alamat_tanah');
            $table->dropColumn('kel_tanah');
            $table->dropColumn('kec_tanah');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrasi', function (Blueprint $table) {
            $table->dropColumn('fungsi_bangunan');
            $table->dropColumn('alamat_tanah');
            $table->dropColumn('kel_tanah');
            $table->dropColumn('kec_tanah');

        });

        Schema::table('permohonan', function (Blueprint $table) {
            $table->string('jenis_bangunan', 50)->nullable();
            $table->string('alamat_tanah')->nullable();
            $table->string('kel_tanah', 50)->nullable();
            $table->string('kec_tanah', 50)->nullable();
        });
    }
};
