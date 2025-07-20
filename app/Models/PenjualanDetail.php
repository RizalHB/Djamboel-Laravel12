<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    protected $fillable = [
    'penjualan_id',
    'inventori_id',
    'jumlah',
    'harga_satuan',
    'subtotal',
    'diskon',
];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function inventori()
    {
        return $this->belongsTo(Inventori::class);
    }
}
