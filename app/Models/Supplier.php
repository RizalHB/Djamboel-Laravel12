<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
    'id_supplier', 'nama', 'alamat',
    'no_rekening', 'no_telepon', 'email'
    ];
    public function inventoris()
    {
        return $this->hasMany(Inventori::class);
    }
}
