<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    protected static ?string $password;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => "Shafa Aulia",
            'username' => "shafaaulia",
            'email'=>"shafaaulia41@yahoo.co.id",
            'password' =>static::$password ??= Hash::make('12345'),
            'role'=> 'admin',
        ]);

        $manajemen = User::create([
            'name' => "Shafa Adha",
            'username' => "shafaaulia",
            'email'=>"adhashafa@gmail.com",
            'password' =>static::$password ??= Hash::make('12345'),
            'role'=> 'manajemen',
        ]);
    }
}
