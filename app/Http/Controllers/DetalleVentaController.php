<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetalleVentaController extends Controller
{
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
    
        $venta_id = $request->id_venta;
    
        if ($producto) {
            // Verificar si la cantidad solicitada no excede el stock disponible
            if ($request->cantidad > $producto->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'La cantidad solicitada excede el stock disponible.'. $producto->stock . ' unidades.'
                ]);
            }
    
            // Verificar si el producto ya existe en el detalle de la venta
            $detalle_ventas_existe = DetalleVenta::where('producto_id', $producto->id)
                ->where('venta_id', $venta_id)
                ->first();
    
            if ($detalle_ventas_existe) {
                // Si ya existe, se actualiza la cantidad
                $detalle_ventas_existe->cantidad += $request->cantidad;
                $detalle_ventas_existe->save();
    
                // Actualizar el stock del producto
                $producto->stock -= $request->cantidad;
                $producto->save();
    
                return response()->json([
                    'success' => true,
                    'message' => 'El producto fue actualizado correctamente.'
                ]);
    
            } else {
                // Si no existe, se crea un nuevo detalle de venta
                $detalle_venta = new DetalleVenta();
                $detalle_venta->cantidad = $request->cantidad;
                $detalle_venta->venta_id = $venta_id;
                $detalle_venta->producto_id = $producto->id;
                $detalle_venta->save();
    
                // Actualizar el stock del producto
                $producto->stock -= $request->cantidad;
                $producto->save();
    
                return response()->json([
                    'success' => true,
                    'message' => 'El producto fue agregado correctamente.'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'El producto no fue encontrado.'
            ]);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(DetalleVenta $detalleVenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetalleVenta $detalleVenta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetalleVenta $detalleVenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * devolver producto a la tienda
     */
    public function destroy($id)
    {
        $detalle_venta = DetalleVenta::find($id);
        $producto = Producto::find($detalle_venta->producto_id);

        $producto->stock += $detalle_venta->cantidad;
        $producto->save();

        DetalleVenta::destroy($id);

        return response()->json(['success'=>true]);
    }
}
