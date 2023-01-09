<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Compra;
use App\Models\ProductosCompra;

class CompraController extends Controller
{
    public function store(Request $request){
        try {
            return DB::transaction(function () use ($request){
                
                $compra = new Compra();
                $compra->subtotal = $request['sub_total'];
                $compra->iva = $request['iva'];
                $compra->total = $request['total'];
                $compra->save();

                for ($i=0; $i < count($request['productos']) ; $i++) { 
                    $element = $request['productos'][$i];
                    $productoCompra = new ProductosCompra();
                    $productoCompra->producto_id = $element['id'];
                    $productoCompra->compra_id = $compra['id'];
                    $productoCompra->save();
                }
            }, 5);            
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function index()
    {
        try {
            $compras = Compra::with(['hasManyProductosCompra:id,compra_id,producto_id',
                                     'hasManyProductosCompra.belongToProducto'])->get();
            return response()->json($compras);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
