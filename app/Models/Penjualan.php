<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PenjualanDetail;

class Penjualan extends Model
{
    protected $fillable = [
    'transaksi_id',
    'metode_pembayaran',
    'tanggal_penjualan',
    'nama_kostumer',
    'total_harga',
    'status_pembayaran', 
    'paid_by_user_id',
    'tanggal_pelunasan',
];


public function inventori()
{
    return $this->belongsTo(Inventori::class, 'inventori_id');
}
    public function kostumer()
{
    return $this->belongsTo(Kostumer::class);
}
public function details()
{
    return $this->hasMany(PenjualanDetail::class);
}
public function paid_by_user()
{
    return $this->belongsTo(User::class, 'paid_by_user_id');
}
protected static function boot()
{
    parent::boot();

    static::creating(function ($penjualan) {
        $tanggal = now()->format('dmY');

        $lastTransaksi = self::whereDate('created_at', today())
            ->orderBy('transaksi_id', 'desc')
            ->first();

        if ($lastTransaksi) {
            $lastNo = intval(substr($lastTransaksi->transaksi_id, -5));
            $nextNo = $lastNo + 1;
        } else {
            $nextNo = 1;
        }

        $penjualan->transaksi_id = 'TRS-' . $tanggal . str_pad($nextNo, 5, '0', STR_PAD_LEFT);
    });
}

}
