<?php

namespace App\Http\Controllers;

use App\Models\Arqueo;
use App\Models\Compras;
use App\Models\DetalleCompra;
use App\Models\Empresa;
use App\Models\MovimientoCaja;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\TmpCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
     { //compartir vista 
         $this->middleware(function ($request, $next){
             if(Auth::check()){
                 $empresa = Empresa::find(Auth::user()->empresa_id);
                 view()->share('empresa', $empresa);
             }
             return $next($request);
         });
     }

    public function index()
    {
        $arqueoAbierto = Arqueo::whereNull('fecha_cierre')
            ->where('empresa_id',Auth::user()->empresa_id)
            ->first();

        $compras = Compras::with('detalles','proveedor')
            ->where('empresa_id',Auth::user()->empresa_id)
            ->get();
        
        return view('admin.compras.index', compact('compras','arqueoAbierto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $productos = Producto::where('empresa_id', Auth::user()->empresa_id)->get();
        $proveedores = Proveedor::where('empresa_id', Auth::user()->empresa_id)->get();
        //traer los datos
        $seseion_id = session()->getId();
        $tmp_compras = TmpCompra::where('seseion_id',$seseion_id)->get();
        
        return view('admin.compras.create', compact('productos','proveedores','tmp_compras'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha'=>'required',
            'comprobante'=>'required',
            'precio_total'=>'required'
            
        ]);

        $compra = new Compras();
        $compra->fecha = $request->fecha;  
        $compra->comprobante = $request->comprobante;
        $compra->precio_total = $request->precio_total;
        $compra->proveedor_id = $request->id_proveedor;
        $compra->empresa_id = Auth::user()->empresa_id;
        $compra->save();
        //registrar en arqueo

        $arqueo_id = Arqueo::whereNull('fecha_cierre')
            ->where('empresa_id',Auth::user()->empresa_id)
            ->first();
        $movimiento = new MovimientoCaja();
        $movimiento->tipo = "EGRESO";
        $movimiento->monto = $request->precio_total;
        $movimiento->descripcion = "compra de productos";
        $movimiento->arqueo_id = $arqueo_id->id;

        $movimiento->save();

         //traer los datos
         $seseion_id = session()->getId();
         $tmp_compras = TmpCompra::where('seseion_id',$seseion_id)->get();
         
         foreach ($tmp_compras as $tmp_compra) {
            $producto = Producto::where('id',$tmp_compra->producto_id)->first();

            //instanciamos el modelo detalle
            $detalle_compra = new DetalleCompra();
            $detalle_compra->cantidad = $tmp_compra->cantidad;
            $detalle_compra->compra_id = $compra->id;
            $detalle_compra->producto_id = $producto->id;
            $detalle_compra->save();

            //actualizar stock

            $producto->stock += $tmp_compra->cantidad;
            $producto->save();
            
         }

            TmpCompra::where('seseion_id',$seseion_id)->delete();

            return redirect()->route('admin.compras.index')
                ->with('mensaje','se registro la compra de la manera correcta')
                ->with('icono','success');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $compras = Compras::with('detalles','proveedor')->findOrFail($id);

        return view('admin.compras.show',compact('compras'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $compras = Compras::with('detalles','proveedor')->findOrFail($id);
        $productos = Producto::where('empresa_id',Auth::user()->empresa_id)->get();
        $proveedores = Proveedor::where('empresa_id',Auth::user()->empresa_id)->get();
        return view('admin.compras.edit',compact('compras','productos','proveedores'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //$datos = request()->all();
        //return response()->json($datos);

        
        $request->validate([
            'fecha'=>'required',
            'comprobante'=>'required',
            'precio_total'=>'required'
            
        ]);

        $compra = Compras::find($id);
        $compra->fecha = $request->fecha;  
        $compra->comprobante = $request->comprobante;
        $compra->precio_total = $request->precio_total;
        $compra->proveedor_id = $request->id_proveedor;
        $compra->empresa_id = Auth::user()->empresa_id;
        $compra->save();

        return redirect()->route('admin.compras.index')
        ->with('mensaje','se actualizo la compra de la manera correcta')
        ->with('icono','success');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $compra = Compras::find($id);

        foreach ($compra->detalles as $detalle) {
            $producto = Producto::find($detalle->producto_id);
            $producto->stock -= $detalle->cantidad;
            $producto->save();
        }

        $compra->detalles()->delete(); //borrar los detalles

        $compra->delete(); // borrar la compra

        return redirect()->route('admin.compras.index')
        ->with('mensaje','se elimino la compra de la manera correcta')
        ->with('icono','success');
    }

    public function reporte(){
        $empresa = Empresa::where('id', Auth::user()->empresa->id)->get()->first();
        $compras = Compras::where('empresa_id', Auth::user()->empresa_id)->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.compras.reporte', compact('compras','empresa'))->setPaper('letter','landscape');
        return $pdf->stream();
    }
}
