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
            $table->string('kdh')->nullable()->change();
        });

        Schema::table('itr', function (Blueprint $table) {
            $table->string('kdh')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skrk', function (Blueprint $table) {
            $table->string('kdh', 100)->nullable()->change();
        });

        Schema::table('itr', function (Blueprint $table) {
            $table->string('kdh', 100)->nullable()->change();
        });
    }
};
