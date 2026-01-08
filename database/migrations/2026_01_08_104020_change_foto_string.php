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
            $table->text('foto_survey')->change();
        });

        Schema::table('itr', function (Blueprint $table) {
            $table->text('foto_survey')->change();
        });

        Schema::table('kkprb', function (Blueprint $table) {
            $table->text('foto_survey')->change();
        });

        Schema::table('kkprnb', function (Blueprint $table) {
            $table->text('foto_survey')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skrk', function (Blueprint $table) {
            $table->string('foto_survey')->change();
        });

        Schema::table('itr', function (Blueprint $table) {
            $table->string('foto_survey')->change();
        });

        Schema::table('kkprb', function (Blueprint $table) {
            $table->string('foto_survey')->change();
        });

        Schema::table('kkprnb', function (Blueprint $table) {
            $table->string('foto_survey')->change();
        });


    }
};
