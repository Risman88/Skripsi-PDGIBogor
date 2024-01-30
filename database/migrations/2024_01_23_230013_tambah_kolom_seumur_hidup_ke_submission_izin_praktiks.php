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
        Schema::table('submission_izin_praktiks', function (Blueprint $table) {
            $table->boolean('seumur_hidup')->default(false);
            $table->date('valid_str')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submission_izin_praktiks', function (Blueprint $table) {
            $table->dropColumn('seumur_hidup');
            // Jika Anda perlu mengembalikan validasi tanggal ke default
            $table->date('valid_str')->nullable(false)->change();
        });
    }
};
