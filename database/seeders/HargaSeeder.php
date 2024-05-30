<?php

namespace Database\Seeders;

use App\Models\ConfigHarga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shafa = ConfigHarga::create([
            'harga_jam_pertama' => 3000.00,
            'harga_per_jam' => 1000.00,
            'harga_menit_pertama' => 100.00,
            'harga_per_menit' => 3000.00,
        ]);
    }
}
