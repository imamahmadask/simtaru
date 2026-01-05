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
            $table->string('akta_pendirian')->nullable();           
            $table->string('sket_lokasi')->nullable();           
        });

        Schema::table('kkprnb', function (Blueprint $table) {
            $table->string('akta_pendirian')->nullable();           
            $table->string('gambar_teknis')->nullable();           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skrk', function (Blueprint $table) {
            $table->dropColumn('akta_pendirian');
            $table->dropColumn('sket_lokasi');
        });

        Schema::table('kkprnb', function (Blueprint $table) {
            $table->dropColumn('akta_pendirian');
            $table->dropColumn('gambar_teknis');
        });
    }
};
