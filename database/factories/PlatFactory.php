<?php

namespace Database\Factories;

use App\Models\QR;
use App\Models\Plat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plat::class>
 */
class PlatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $qrs = QR::all();

        foreach ($qrs as $qr) {
            // Pastikan no_plat yang diambil dari QR adalah unik
            $existingPlat = Plat::where('no_plat', $qr->no_plat)->first();

            if (!$existingPlat) {
                // Jika no_plat belum ada di tabel plats, buat entri baru
                Plat::create([
                    'no_plat' => $qr->no_plat,
                    'q_r_id' => $qr->id,
                ]);
            }
        }
    }
}
