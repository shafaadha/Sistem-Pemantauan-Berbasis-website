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
        Schema::create('config_hargas', function (Blueprint $table) {
            $table->id();
            $table->decimal('harga_jam_pertama', 8, 2)->nullable();
            $table->decimal('harga_per_jam', 8, 2)->nullable();
            $table->decimal('harga_menit_pertama', 8, 2)->nullable();
            $table->decimal('harga_per_menit', 8, 2)->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_hargas');
    }
};
