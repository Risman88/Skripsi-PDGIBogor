<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoomMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('zoom_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('untuk_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('dibuat_oleh')->references('id')->on('users')->onDelete('cascade');
            $table->string('title');
            $table->string('description')->nullable();
            $table->dateTime('start_time');
            $table->integer('duration');
            $table->enum('status', ['Hadir', 'Tidak Hadir'])->default('Tidak Hadir');
            $table->bigInteger('zoom_meeting_id')->nullable();
            $table->string('password')->nullable();
            $table->string('link_zoom');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoom_meetings');
    }
};
