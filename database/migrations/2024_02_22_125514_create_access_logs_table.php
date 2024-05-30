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
        Schema::create('access_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('q_r_id');
            $table->string('code');
            $table->string('no_plat')->nullable();
            $table->date('date');
            $table->time('time_masuk');
            $table->time('time_keluar')->nullable();
            $table->string('status_in');
            $table->string('status_out')->nullable();
            $table->string('waktu')->nullable();  
        });

        Schema::table('access_logs', function (Blueprint $table) {
           
            // relation to qr table
            $table->foreign('q_r_id')->references('id')->on('q_r_s')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_logs');
    }
};
