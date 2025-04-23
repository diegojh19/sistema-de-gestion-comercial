<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\TmpVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TmpVentaController extends Controller
{

    public function tmp_ventas(Request $request)
{

            // Validar que la cantidad solicitada sea mayor que cero
            if ($request->cantidad <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'La cantidad solicitada debe ser mayor a cero.'
                ]);
            }

            

       $producto = Producto::where('codigo', $request->codigo)
                        ->where('empresa_id', Auth::user()->empresa_id)
                        ->first();

     
    
    if (!$producto) {
        return response()->json([ 'success' => false, 'message' => 'El producto no encontrado']);
    }

    if ($request->cantidad > $producto->stock) {
        return response()->json([ 
            'success' => false, 
            'message' => 'La cantidad solicitada excede el stock disponible. Solo quedan'. $producto->stock . ' unidades.'
        ]);
    }

      //  Advertencia si está en stock mínimo
      $advertencia_stock_minimo = null;
      if ($producto->stock <= $producto->stock_minimo) {
          $advertencia_stock_minimo = ' El producto está en stock mínimo. Quedan ' . $producto->stock . ' unidades.';
      }

    $seseion_id = session()->getId();

    //  Verificar si el producto ya está en el carrito (TmpVenta)
    $tmp_ventas_existe = TmpVenta::where('producto_id', $producto->id)
                                  ->where('seseion_id', $seseion_id)
                                  ->first();
    
    // Si el producto ya existe en el carrito
    if ($tmp_ventas_existe) {
        // Comprobar que no superamos el stock con la nueva cantidad
        if ($tmp_ventas_existe->cantidad + $request->cantidad > $producto->stock) {
            return response()->json([ 
                'success' => false, 
                'message' => 'La cantidad total no puede superar el stock disponible.'. $producto->stock . ' unidades.'
            ]);
        }

        // Actualizar la cantidad 
        $tmp_ventas_existe->cantidad += $request->cantidad;
        $tmp_ventas_existe->save();
        

        return response()->json([ 'success' => true, 'message' => 'El producto fue encontrado y actualizado.' ,'advertencia' => $advertencia_stock_minimo 
       
]);
    } else {
        // Si el producto no está , agregarlo
        $tmp_venta = new TmpVenta();
        $tmp_venta->cantidad = $request->cantidad;
        $tmp_venta->producto_id = $producto->id;
        $tmp_venta->seseion_id = $seseion_id;
        $tmp_venta->save();

        return response()->json([ 'success' => true, 'message' => 'El producto fue agregado.' ,'advertencia' => $advertencia_stock_minimo
]);
    }
}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TmpVenta $tmpVenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TmpVenta $tmpVenta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TmpVenta $tmpVenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        TmpVenta::destroy($id);
        return response()->json([ 'success' =>true]);
    }
}
