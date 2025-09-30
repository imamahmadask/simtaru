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
        Schema::table('permohonan', function (Blueprint $table) {
            $table->string('no_dokumen')->after('tgl_selesai')->nullable();
            $table->string('waktu_pengerjaan')->after('no_dokumen')->nullable();
            $table->boolean('is_done')->after('berkas_kuasa')->default(0);

            $table->date('tgl_selesai')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropColumn('no_dokumen');
            $table->dropColumn('waktu_pengerjaan');
            $table->dropColumn('is_done');

            $table->datetime('tgl_selesai',)->nullable()->change();
        });
    }
};
