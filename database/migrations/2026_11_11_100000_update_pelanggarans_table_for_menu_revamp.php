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
            $table->string('nama_pemilik_perusahaan')->nullable()->after('nama_pelanggar');
            $table->string('jenis_indikasi_pelanggaran')->nullable()->change();
            $table->string('alamat_pelanggar')->nullable()->change();
            $table->string('kel_pelanggar')->nullable()->change();
            $table->string('kec_pelanggar')->nullable()->change();
            $table->string('kota_pelanggar')->nullable()->change();
            $table->string('prov_pelanggar')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggarans', function (Blueprint $table) {
            $table->dropColumn('nama_pemilik_perusahaan');
        });
    }
};
