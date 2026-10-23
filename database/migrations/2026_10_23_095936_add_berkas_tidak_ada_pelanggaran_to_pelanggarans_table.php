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
            $table->string('file_kkpr_skrk')->nullable();
            $table->string('file_pbg_imb')->nullable();
            $table->string('file_nib_kbli')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggarans', function (Blueprint $table) {
            $table->dropColumn(['file_kkpr_skrk', 'file_pbg_imb', 'file_nib_kbli']);
        });
    }
};
