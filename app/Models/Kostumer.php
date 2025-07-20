<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kostumer extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'no_telepon', 'alamat'];

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }
    protected static function boot()
{
    parent::boot();

    static::creating(function ($kostumer) {
        $tanggal = now()->format('dmY');
        $lastId = self::max('id') + 1;
        $kostumer->kode_kostumer = 'KOS-' . $tanggal . str_pad($lastId, 5, '0', STR_PAD_LEFT);
    });
}

}
