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
            $table->string('status_modal', 50)->nullable();
            $table->string('kbli', 100)->nullable();
            $table->string('judul_kbli', 100)->nullable();
        });

        Schema::table('skrk', function (Blueprint $table) {
            $table->dropColumn('status_modal');
            $table->dropColumn('kbli');
            $table->dropColumn('judul_kbli');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropColumn('status_modal');
            $table->dropColumn('kbli');
            $table->dropColumn('judul_kbli');
        });

        Schema::table('skrk', function (Blueprint $table) {
            $table->string('status_modal', 50)->nullable();
            $table->string('kbli', 100)->nullable();
            $table->string('judul_kbli', 100)->nullable();
        });
    }
};
