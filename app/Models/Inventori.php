<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventori extends Model
{
    use HasFactory;
    protected $table = 'inventoris';
    protected $fillable = [
        'nama_barang',
        'unit',
        'amount',
        'price_per_unit',
        'supplier',
        'harga_jual',
        'tanggal_pembelian',
        'supplier_id',
        'initial_amount',
    ];
    public function penjualans()
{
    return $this->hasMany(Penjualan::class);
    
    
}
    public function supplier()
{
    return $this->belongsTo(Supplier::class);
}
public function pengeluarans()
{
    return $this->hasMany(InventoriPengeluaran::class);
}
protected static function boot()
{
    parent::boot();

    static::creating(function ($inventori) {
        $tanggal = now()->format('dmY');
        $lastKode = self::where('kode_barang', 'like', 'PMB-' . $tanggal . '%')
            ->orderBy('kode_barang', 'desc')
            ->first();

        if ($lastKode) {
            $lastNumber = intval(substr($lastKode->kode_barang, -5));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $inventori->kode_barang = 'PMB-' . $tanggal . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    });
}

}
