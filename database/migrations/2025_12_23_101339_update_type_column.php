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
            $table->text('judul_kbli')->nullable()->change();
        });

        Schema::table('skrk', function (Blueprint $table) {
            $table->text('penguasaan_tanah')->nullable()->change();
        });

        Schema::table('itr', function (Blueprint $table) {
            $table->text('penguasaan_tanah')->nullable()->change();
        });

        Schema::table('kkprnb', function (Blueprint $table) {
            $table->text('penguasaan_tanah')->nullable()->change();
        });

        Schema::table('kkprb', function (Blueprint $table) {
            $table->text('penguasaan_tanah')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->string('judul_kbli')->nullable()->change();
        });

        Schema::table('skrk', function (Blueprint $table) {
            $table->string('penguasaan_tanah')->nullable()->change();
        });

        Schema::table('itr', function (Blueprint $table) {
            $table->string('penguasaan_tanah')->nullable()->change();
        });

        Schema::table('kkprnb', function (Blueprint $table) {
            $table->string('penguasaan_tanah')->nullable()->change();
        });

        Schema::table('kkprb', function (Blueprint $table) {
            $table->string('penguasaan_tanah')->nullable()->change();
        });
    }
};
