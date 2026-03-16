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
            $table->boolean('is_ditolak')->default(false);
            $table->string('surat_penolakan')->nullable();
            $table->text('alasan_ditolak')->nullable();
            $table->date('tgl_surat_penolakan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropColumn(['is_ditolak', 'surat_penolakan', 'alasan_ditolak', 'tgl_surat_penolakan']);
        });
    }
};
