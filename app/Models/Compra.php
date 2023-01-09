<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function hasManyProductosCompra()
    {
        return $this->hasMany(ProductosCompra::class, 'compra_id');
    }
}
