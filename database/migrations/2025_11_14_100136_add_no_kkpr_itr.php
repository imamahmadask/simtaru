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
            $table->string('no_kkkpr')->nullable()->after('jenis_itr');
            $table->string('dokumen_kkkpr')->nullable()->after('no_kkkpr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('itr', function (Blueprint $table) {
            $table->dropColumn('no_kkkpr');
        });
    }
};
