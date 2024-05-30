<?php

namespace Database\Factories;

use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengguna>
 */
class PenggunaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Pengguna::class;
    public function definition(): array
    {
        return [
            'name' =>$this->faker->name(),
            'nim' =>$this->faker->unique()->randomNumber(8),
            'phone_number' =>$this->faker->e164PhoneNumber(),
            'jurusan' => 'Teknik Elektro'

        ];
    }
}
