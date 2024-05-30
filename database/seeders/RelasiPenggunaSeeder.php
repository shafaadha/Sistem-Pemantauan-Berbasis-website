<?php

namespace Database\Seeders;

use App\Models\QR;
use Carbon\Carbon;
use App\Models\Pengguna;
use App\Models\Plat;
use Illuminate\Support\Str;
use FontLib\Table\Type\name;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RelasiPenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Pengguna
        $shafa = Pengguna::create([
            'name' => "Shafa Aulia",
            'nim' => "21060119140178",
            'phone_number' => "08116605134",
            'jurusan' => "Teknik Elektro",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $sehatian = Pengguna::create([
            'name' => "Sehatian",
            'nim' => "21060119140180",
            'phone_number' => "08126605134",
            'jurusan' => "Teknik Elektro",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $irfan = Pengguna::create([
            'name' => "Sehatian",
            'nim' => "21060119120001",
            'phone_number' => "08126505134",
            'jurusan' => "Teknik Elektro",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $tamu1 = Pengguna::create([
            'name' => "Tamu 1",
            'nim' => "2106011900000",
            'phone_number' => "0000000000",
            'jurusan' => "Teknik Elektro",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $this->command->info('Mahasiswa telah diisi!');

        //QR

        $qr_shafa = QR::create([
            'pengguna_id' => $shafa->id,
            'code' => Str::random(10),
            'no_plat' => Str::random(5),
            'kategori' => 'pengguna',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $qr_sehatian =QR::create([
            'pengguna_id' => $sehatian->id,
            'code' => Str::random(10),
            'no_plat' => Str::random(5),
            'kategori' => 'pengguna',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $qr_irfan = QR::create([
            'pengguna_id' => $irfan->id,
            'code' => Str::random(10),
            'no_plat' => Str::random(5),
            'kategori' => 'pengguna',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $qr_tamu1 = QR::create([
            'pengguna_id' => $tamu1->id,
            'code' => Str::random(10),
            'no_plat' => Str::random(5),
            'kategori' => 'tamu',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $this->command->info('Data pengguna dan QR telah diisi');
    }
}
