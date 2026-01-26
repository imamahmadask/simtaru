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
        $tables = ['skrk', 'itr', 'kkprb', 'kkprnb'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->boolean('is_survey_hold')->default(false)->nullable()->after('foto_survey');
                $table->date('tgl_survey_hold')->nullable()->after('is_survey_hold');
                $table->date('tgl_survey_unhold')->nullable()->after('tgl_survey_hold');
                $table->text('ket_survey_hold')->nullable()->after('tgl_survey_unhold');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['skrk', 'itr', 'kkprb', 'kkprnb'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn(['is_survey_hold', 'tgl_survey_hold', 'tgl_survey_unhold', 'ket_survey_hold']);
            });
        }
    }
};
