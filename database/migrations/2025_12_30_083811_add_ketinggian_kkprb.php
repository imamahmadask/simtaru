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
        Schema::table('kkprb', function (Blueprint $table) {
            $table->string('ketinggian_min')->nullable()->after('kedalaman_min');
            $table->string('ketinggian_max')->nullable()->after('kedalaman_max');
            $table->dropColumn('no_nota_dinas');
            $table->dropColumn('tgl_nota_dinas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kkprb', function (Blueprint $table) {
            $table->dropColumn('ketinggian_min');
            $table->dropColumn('ketinggian_max');
            $table->string('no_nota_dinas')->nullable()->after('kedalaman_max');
            $table->string('tgl_nota_dinas')->nullable()->after('no_nota_dinas');
        });
    }
};
