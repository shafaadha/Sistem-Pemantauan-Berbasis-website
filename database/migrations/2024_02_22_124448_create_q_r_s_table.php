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
        Schema::create('q_r_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengguna_id');
            $table->string('code')->unique();
            $table->string('no_plat')->unique();
            $table->string('kategori');
            $table->timestamps();
        });

        Schema::table('q_r_s', function (Blueprint $table){
            $table->foreign('pengguna_id')->references('id')->on('penggunas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('q_r_s');
    }
};
