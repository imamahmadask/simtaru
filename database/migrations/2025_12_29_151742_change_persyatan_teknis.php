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
            $table->text('persyaratan_pelaksanaan')->nullable()->change();
        });

        Schema::table('itr', function (Blueprint $table) {
            $table->text('persyaratan_pelaksanaan')->nullable()->change();
        });

        Schema::table('kkprnb', function (Blueprint $table) {
            $table->text('persyaratan_pelaksanaan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skrk', function (Blueprint $table) {
            $table->string('persyaratan_pelaksanaan')->nullable()->change();
        });

        Schema::table('itr', function (Blueprint $table) {
            $table->string('persyaratan_pelaksanaan')->nullable()->change();
        });

        Schema::table('kkprnb', function (Blueprint $table) {
            $table->string('persyaratan_pelaksanaan')->nullable()->change();
        });
    }
};
