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
        Schema::create('submission_anggotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->references('id')->on('submissions')->onDelete('cascade');
            $table->string('str', 25);
            $table->string('serkom', 25);
            $table->string('cabang_mutasi', 40)->nullable();
            $table->string('scan_str');
            $table->string('scan_serkom');
            $table->string('scan_mutasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_anggotas');
    }
};
