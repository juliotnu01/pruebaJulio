<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Inertia\Inertia;
use DB;

class ProductoController extends Controller
{
    public function index(){
        try {
            $producto = Producto::all();
            return response()->json($producto);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($producto)
    {
        try {
            $producto = Producto::find($producto);
            return Inertia::render('Viewproductos', [
                "producto" => $producto
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function update(Request $request, $producto)
    {
        try {
            return DB::transaction(function () use ($request, $producto) {
                Producto::find($producto)->update([
                    "producto" => $request['producto'],
                    "precio" => $request['precio'],
                    "impuesto" => $request['impuesto'],
                ]);
            }, 5);


        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function delete($producto)
    {
        try {
            return DB::transaction(function () use ($producto) {
                Producto::find($producto)->delete();
            }, 5);


        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
