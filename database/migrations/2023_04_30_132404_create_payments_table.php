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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('submission_id')->nullable()->references('id')->on('submissions')->onDelete('cascade');
            $table->string('jenis_pembayaran');
            $table->integer('jangka_iuran')->nullable();
            $table->integer('jumlah_pembayaran');
            $table->enum('status', ['Belum dibayar', 'Menunggu konfirmasi', 'Lunas']);
            $table->string('nama_bank', 20);
            $table->string('nomor_rekening', 20);
            $table->string('nama_rekening', 50);
            $table->string('bukti_pembayaran')->nullable();
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
