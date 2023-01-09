<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosCompra extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function belongToProducto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
