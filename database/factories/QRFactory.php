<?php

namespace Database\Factories;

use App\Models\Pengguna;
use App\Models\QR;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QR>
 */
class QRFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = QR::class;
    public function definition(): array
    {
        $kategori = $this->faker->randomElement(['pengguna', 'tamu']);
        return [
            'code'=>$this->faker->regexify('[A-Za-z0-9]{10}'),
            'no_plat'=>$this->faker->regexify('[A-Za-z0-9]{5}'),
            'kategori'=>$kategori,
            'pengguna_id' =>Pengguna::factory()->create()->id,
            ];
    }

    // public function configure()
    // {
    //     return $this->afterCreating(function (QR $qr) {
    //         $pengguna = $qr->pengguna()->firstOr(function () {
    //             return Pengguna::factory()->create();
    //         });

    //         $qr->update(['pengguna_id' => $pengguna->id]);
    //     });
    // }
}

