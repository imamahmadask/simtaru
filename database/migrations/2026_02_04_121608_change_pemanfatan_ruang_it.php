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
        Schema::table('itr', function (Blueprint $table) {
            $table->text('pemanfaatan_ruang')->nullable()->change();
        });

        Schema::table('skrk', function (Blueprint $table) {
            $table->text('pemanfaatan_ruang')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('itr', function (Blueprint $table) {
            $table->string('pemanfaatan_ruang')->nullable()->change();
        });

        Schema::table('skrk', function (Blueprint $table) {
            $table->string('pemanfaatan_ruang')->nullable()->change();
        });
    }
};
