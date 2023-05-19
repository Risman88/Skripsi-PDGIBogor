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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('submission_type_id')->references('id')->on('submission_types')->onDelete('cascade');
            $table->enum('status', ['Diproses', 'Selesai', 'Ditolak']);
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->onDelete('set null');
            $table->string('surat_keluar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
