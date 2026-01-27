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
        Schema::table('kkprnb', function (Blueprint $table) {
            $table->boolean('is_analis_hold')->default(false)->nullable()->after('rdtr_rtrw');
            $table->date('tgl_analis_hold')->nullable()->after('is_analis_hold');
            $table->date('tgl_analis_unhold')->nullable()->after('tgl_analis_hold');
            $table->text('ket_analis_hold')->nullable()->after('tgl_analis_unhold');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kkprnb', function (Blueprint $table) {
            $table->dropColumn(['is_analis_hold', 'tgl_analis_hold', 'tgl_analis_unhold', 'ket_analis_hold']);
        });
    }
};
