<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('submission_izin_praktiks', function (Blueprint $table) {
            // Tambahkan nilai enum baru ke dalam kolom tujuan_surat
            $table->enum('tujuan_surat', ['Pembuatan SIP', 'Perpanjangan SIP', 'Pindah Alamat SIP', 'Pencabutan SIP'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submission_izin_praktiks', function (Blueprint $table) {
            $table->enum('tujuan_surat', ['Pembuatan SIP', 'Perpanjangan SIP', 'Pindah Alamat SIP']);
        });
    }
};
