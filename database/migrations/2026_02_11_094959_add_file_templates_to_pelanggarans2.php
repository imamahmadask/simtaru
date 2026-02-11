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
            $table->string('file_ba_pengambilan_dokumen')->nullable()->after('file_sosialisasi');
            $table->string('file_ba_penolakan')->nullable()->after('file_ba_pengambilan_dokumen');
            $table->string('file_ba_survey')->nullable()->after('file_ba_penolakan');
            $table->string('file_ba_survey_surveyor')->nullable()->after('file_ba_survey');
            $table->string('file_ba_wawancara')->nullable()->after('file_ba_survey_surveyor');
            $table->string('file_ba_penerapan_sanksi')->nullable()->after('file_ba_wawancara');
            $table->string('file_ba_sosialisasi')->nullable()->after('file_ba_penerapan_sanksi');
            $table->string('file_sk_sanksi_pemberhentian')->nullable()->after('file_ba_sosialisasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggarans', function (Blueprint $table) {
            $table->dropColumn('file_ba_pengambilan_dokumen');
            $table->dropColumn('file_ba_penolakan');
            $table->dropColumn('file_ba_survey');
            $table->dropColumn('file_ba_survey_surveyor');
            $table->dropColumn('file_ba_wawancara');
            $table->dropColumn('file_ba_penerapan_sanksi');
            $table->dropColumn('file_ba_sosialisasi');
            $table->dropColumn('file_sk_sanksi_pemberhentian');
        });
    }
};
