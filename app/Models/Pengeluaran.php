<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $fillable = [
    'id_pengeluaran',
    'nama_pengeluaran',
    'kuantitas',
    'harga_satuan',
    'total_harga',
    'kategori',
    'tanggal_pengeluaran',
    'keterangan',
];    
}