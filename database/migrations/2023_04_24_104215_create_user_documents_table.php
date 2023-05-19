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
        Schema::create('user_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('scan_ktp')->nullable();
            $table->string('scan_kta')->nullable();
            $table->string('scan_s1')->nullable();
            $table->string('scan_s2')->nullable();
            $table->string('scan_drg')->nullable();
            $table->string('scan_drgsp')->nullable();
            $table->string('scan_foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_documents');
    }
};
