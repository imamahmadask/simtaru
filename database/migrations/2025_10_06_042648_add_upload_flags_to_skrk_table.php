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
            $table->boolean('is_berkas_survey_uploaded')->default(false)->after('is_survey');
            $table->boolean('is_berkas_analis_uploaded')->default(false)->after('is_dokumen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skrk', function (Blueprint $table) {
            $table->dropColumn(['is_berkas_survey_uploaded', 'is_berkas_analis_uploaded']);
        });
    }
};
