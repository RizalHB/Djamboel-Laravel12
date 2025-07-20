<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        Supplier::create([
            'nama' => 'Supplier Ayam Bandung',
            'telepon' => '081234567890',
            'alamat' => 'Jl. Ayam No.1, Bandung'
        ]);
    }
}

