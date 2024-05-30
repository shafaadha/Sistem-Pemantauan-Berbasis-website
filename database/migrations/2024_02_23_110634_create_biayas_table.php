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
        Schema::create('biayas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('log_id');
            $table->decimal('biaya')->nullable();
            $table->timestamps();
        });

        Schema::table('biayas', function (Blueprint $table) {
           
            // relation to acceslog
            $table->foreign('log_id')->references('id')->on('access_logs')->onUpdate('cascade')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biayas');
    }
};
