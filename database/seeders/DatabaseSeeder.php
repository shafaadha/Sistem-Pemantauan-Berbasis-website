<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\QR;

use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\RelasiPenggunaSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;


class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Memanggil seeder lain di sini jika diperlukan
        $this->call([
            UserSeeder::class,
            RelasiPenggunaSeeder::class,
            HargaSeeder::class
        ]);

        // // Membuat instance Faker
        // $faker = FakerFactory::create();

        // // Membuat entri pengguna
        // $pengguna = Pengguna::factory(12)->create();

        // // Membuat 12 entri QR, setiap entri QR terkait dengan pengguna yang sama
        // $jumlahEntriQR = 12;
        // for ($i = 0; $i < $jumlahEntriQR; $i++) {
        //     $kategori = $faker->randomElement(['pengguna', 'tamu']); // Menggunakan $faker untuk mengakses metode randomElement
        //     QR::factory()->create([
        //         'code' => $faker->regexify('[A-Za-z0-9]{10}'), // Menggunakan $faker untuk mengakses metode regexify
        //         'no_plat' => $faker->regexify('[A-Za-z0-9]{5}'), // Menggunakan $faker untuk mengakses metode regexify
        //         'kategori' => $kategori,
        //         'pengguna_id' => $pengguna->id,
        //     ]);
        // }

    }
}
