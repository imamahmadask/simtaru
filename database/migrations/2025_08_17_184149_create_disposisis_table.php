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
        Schema::create('disposisis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonan')->onDelete('cascade');
            $table->foreignId('tahapan_id')->constrained('tahapans')->onDelete('cascade');
            $table->foreignId('pemberi_id')->constrained('users')->onDelete('cascade'); // supervisor/atasan
            $table->foreignId('penerima_id')->constrained('users')->onDelete('cascade'); // surveyor/analis sesuai tahap
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal_disposisi')->useCurrent();
            $table->timestamps();

            $table->unique(['permohonan_id', 'tahapan_id']); // 1 disposisi per tahapan untuk 1 permohonan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisis');
    }
};
