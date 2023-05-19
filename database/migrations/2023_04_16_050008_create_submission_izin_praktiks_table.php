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
        Schema::create('submission_izin_praktiks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->references('id')->on('submissions')->onDelete('cascade');
            $table->enum('praktik_ke', ['1', '2', '3']);
            $table->enum('tujuan_surat', ['Pembuatan SIP', 'Perpanjangan SIP', 'Pindah Alamat SIP']);
            $table->string('alumni_drg', 50);
            $table->string('tahun_lulus', 5);
            $table->string('str', 25);
            $table->date('valid_str');
            $table->string('serkom', 25);
            $table->string('npa', 11);
            $table->string('cabang_pdgi', 40);
            $table->string('alamat_fakes1')->nullable();
            $table->string('jadwal_praktik1')->nullable();
            $table->string('surat_praktik1')->nullable();
            $table->string('alamat_fakes2')->nullable();
            $table->string('jadwal_praktik2')->nullable();
            $table->string('surat_praktik2')->nullable();
            $table->string('alamat_fakes3')->nullable();
            $table->string('jadwal_praktik3')->nullable();
            $table->string('surat_praktik3')->nullable();
            $table->string('scan_serkom');
            $table->string('scan_str');
            $table->string('scan_surat_sehat');
            $table->string('surat_mkekg')->nullable();
            $table->string('scan_surat_pengantar')->nullable();
            $table->string('scan_surat_kolegium')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_izin_praktiks');
    }
};
