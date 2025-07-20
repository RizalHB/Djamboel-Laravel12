<?php

namespace Database\Seeders;

use App\Models\Inventori;
use Illuminate\Database\Seeder;

class InventoriSeeder extends Seeder
{
    public function run()
    {
        Inventori::create([
            'supplier_id' => 1,
            'nama_barang' => 'Dada Ayam Fillet',
            'unit' => 'Kg',
            'amount' => 20,
            'price_per_unit' => 28000,
            'harga_jual' => 35000,
            'tanggal_pembelian' => now()
        ]);
    }
}
