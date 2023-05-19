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
        Schema::create('submission_mutasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->references('id')->on('submissions')->onDelete('cascade');
            $table->string('npa', 11);
            $table->string('mutasi_ke', 40);
            $table->string('alasan_mutasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_mutasis');
    }
};
