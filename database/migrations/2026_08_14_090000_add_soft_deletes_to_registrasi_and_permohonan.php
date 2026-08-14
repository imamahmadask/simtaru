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
            $table->softDeletes();
        });

        Schema::table('permohonan', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('skrk', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('kkprb', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('kkprnb', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('itr', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrasi', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('skrk', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('kkprb', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('kkprnb', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('itr', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
