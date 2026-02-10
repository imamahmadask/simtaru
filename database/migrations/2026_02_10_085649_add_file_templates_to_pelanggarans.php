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
        Schema::table('pelanggarans', function (Blueprint $table) {
            $table->string('file_sp1')->nullable()->after('foto_existing');
            $table->string('file_sp2')->nullable()->after('file_sp1');
            $table->string('file_sp3')->nullable()->after('file_sp2');
            $table->string('file_pelimpahan_polpp')->nullable()->after('file_sp3');
            $table->string('file_pernyataan')->nullable()->after('file_pelimpahan_polpp');
            $table->string('file_sosialisasi')->nullable()->after('file_pernyataan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggarans', function (Blueprint $table) {
            $table->dropColumn([
                'file_sp1',
                'file_sp2',
                'file_sp3',
                'file_pelimpahan_polpp',
                'file_pernyataan',
                'file_sosialisasi'
            ]);
        });
    }
};
