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
        Schema::table('permohonan', function (Blueprint $table) {
            $table->boolean('is_survey')->default(false);
            $table->boolean('is_analis')->default(false);
            $table->boolean('is_validate')->default(false);
            $table->boolean('is_prioritas')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropColumn('is_survey');
            $table->dropColumn('is_analis');
            $table->dropColumn('is_validate');
            $table->dropColumn('is_prioritas');
        });
    }
};
