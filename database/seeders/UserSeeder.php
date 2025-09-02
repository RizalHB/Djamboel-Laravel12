<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@potongayam.com'],
            [
                'kode_user'   => 'AdM-Djamboel',
                'name'        => 'Admin',
                'nama_lengkap'=> 'Oriza Sativa',
                'password'    => Hash::make('password123'),
                'role'        => 'admin',
            ]
        );
    }
}
