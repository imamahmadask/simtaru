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
        Schema::table('permohonan_berkas', function (Blueprint $table) {
            $table->string('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan_berkas', function (Blueprint $table) {
            $table->dropColumn('verified_by');
            $table->dropColumn('verified_at');
        });
    }
};
