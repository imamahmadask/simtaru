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
            $table->string('jba')->nullable()->after('gsb');
            $table->renameColumn('is_berkas_kajian_uploaded', 'is_berkas_analis_uploaded');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kkprnb', function (Blueprint $table) {
            $table->dropColumn('jba');
            $table->renameColumn('is_berkas_analis_uploaded', 'is_berkas_kajian_uploaded');
        });
    }
};
