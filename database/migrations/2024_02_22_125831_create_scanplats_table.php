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
        Schema::create('scanplats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('log_id');
            $table->string('no_plat');
            $table->string('plat_masuk');
            $table->string('plat_keluar')->nullable();
            $table->string('similarity_masuk');
            $table->string('similarity_keluar')->nullable()->default('some_default_value');
            $table->string('gambar_in')->nullable();
            $table->string('gambar_out')->nullable();
            $table->date('date');
            $table->time('tcek_masuk');
            $table->time('tcek_keluar')->nullable();
            $table->string('status_in');
            $table->string('status_out')->nullable();
        });

        Schema::table('scanplats', function (Blueprint $table) {
           
            // relation to acceslog
            $table->foreign('log_id')->references('id')->on('access_logs')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scanplats');
    }
};
