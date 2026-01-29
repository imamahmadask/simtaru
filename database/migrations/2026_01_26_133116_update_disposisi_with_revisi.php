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
        Schema::table('disposisis', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->constrained('disposisis')->onDelete('cascade');
            $table->string('status')->default('pending');
            $table->boolean('is_revisi')->default(false);
            $table->timestamp('tgl_selesai')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disposisis', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'status', 'is_revisi']);
            $table->date('tgl_selesai')->nullable()->change();
        });
    }
};
