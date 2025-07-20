<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class InventoriPengeluaran extends Model
{
    protected $fillable = [
        'inventori_id', 'jumlah', 'harga_satuan'
    ];
    public function inventori()
    {
        return $this->belongsTo(Inventori::class);
    }
}