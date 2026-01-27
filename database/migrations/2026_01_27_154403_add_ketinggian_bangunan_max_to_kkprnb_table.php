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
            $table->string('ketinggian_bangunan_max')->nullable()->after('kdh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kkprnb', function (Blueprint $table) {
            $table->dropColumn('ketinggian_bangunan_max');
        });
    }
};
