<?php

namespace App\Http\Controllers;

use App\Models\Arqueo;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Empresa;
use App\Models\MovimientoCaja;
use App\Models\Producto;
use App\Models\TmpVenta;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nnjeim\World\Models\Currency;
use NumberToWords\NumberToWords;
use NumberFormatter;
class VentaController extends Controller
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
        $ventas = Venta::with('detallesventa', 'cliente')
            ->where('empresa_id', Auth::user()->empresa_id)
            ->get();
        
        return view('admin.ventas.index', compact('ventas','arqueoAbierto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $productos = Producto::where('empresa_id', Auth::user()->empresa_id)->get();
        $clientes =  Cliente::where('empresa_id', Auth::user()->empresa_id)->get();

        $seseion_id = session()->getId();
        $tmp_ventas = TmpVenta::where('seseion_id',$seseion_id)->get();
       
        return view('admin.ventas.create', compact('productos','clientes','tmp_ventas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$datos = request()->all();
        //return response()->json($datos);

        $request->validate([
            'fecha'=>'required',
            'precio_total' => 'required|numeric|min:0.01',
            
        ]);

        if ($request->precio_total > 0) {
            $venta = new Venta();
            $venta->fecha = $request->fecha;  
            $venta->precio_total = $request->precio_total;
            $venta->empresa_id = Auth::user()->empresa_id;
            $venta->cliente_id = $request->id_cliente;
            $venta->save();
        } else {
            return redirect()->back()->with('error', 'El precio total debe ser mayor a cero.');
        }
        
        //registrar en arqueo

        $arqueo_id = Arqueo::whereNull('fecha_cierre')
            ->where('empresa_id',Auth::user()->empresa_id)
            ->first();
        $movimiento = new MovimientoCaja();
        $movimiento->tipo = "INGRESO";
        $movimiento->monto = $request->precio_total;
        $movimiento->descripcion = "venta de productos";
        $movimiento->arqueo_id = $arqueo_id->id;

        $movimiento->save();

        //

         //traer los datos
         $seseion_id = session()->getId();
         $tmp_ventas = TmpVenta::where('seseion_id',$seseion_id)->get();
         
         foreach ($tmp_ventas as $tmp_venta) {
            $producto = Producto::where('id',$tmp_venta->producto_id)->first();

            //instanciamos el modelo detalle
            $detalle_venta = new DetalleVenta();
            $detalle_venta->cantidad = $tmp_venta->cantidad;
            $detalle_venta->venta_id = $venta->id;
            $detalle_venta->producto_id = $producto->id;
            $detalle_venta->save();

            //actualizar stock

            $producto->stock -= $tmp_venta->cantidad;
            $producto->save();

             
         }

            TmpVenta::where('seseion_id',$seseion_id)->delete();

            return redirect()->route('admin.ventas.index')
                ->with('mensaje','se registro la venta de la manera correcta')
                ->with('icono','success');
    }

    public function cliente_store(Request $request){
        $request->validate([
            'nombre_cliente'=>'required',
            'nit_codigo'=>'required',
            'telefono'=>'required',
            'email'=>'required'
            
        ]);

        $clientes = new Cliente();
        $clientes->nombre_cliente = $request->nombre_cliente;
        $clientes->nit_codigo = $request->nit_codigo;
        $clientes->telefono = $request->telefono;
        $clientes->email = $request->email;
        $clientes->empresa_id = Auth::user()->empresa_id;

        $clientes->save();

        return response()->json(['success' =>'cliente ref¿gistrado']);
    }

    public function pdf($id){

        function numeroALetrasConDecimales($numero){
            $formatter = new NumberFormatter("es", NumberFormatter::SPELLOUT);
            $partes = explode('.', number_format($numero,2,'.',''));
            $entero = $formatter->format($partes[0]);
            $decimal = $formatter->format($partes[1]);

            return ucfirst("$entero con $decimal/100");

        }

        $empresa_id = Auth::user()->empresa_id;
        $empresa = Empresa::where('id', $empresa_id)->first();
        $ventas = Venta::with('detallesventa','cliente')->findOrFail($id);
        $moneda = Currency::find($empresa->moneda);
        $venta = Venta::where('fecha', '!=', null)->first(); 

        $numero = $ventas->precio_total;
        $literal =  numeroALetrasConDecimales($numero);
        if ($venta) {
            
            $fechaFormateada = Carbon::parse($venta->fecha)->locale('es')->isoFormat('D [de] MMMM [de] YYYY');
            echo $fechaFormateada; 
        } else {
            echo "No se encontró la venta.";
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.ventas.pdf', compact('empresa','ventas','fechaFormateada','moneda','literal'));
        
        //incluir la numeracion de pagina y el pie de página
        
        return $pdf->stream();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ventas = Venta::with('detallesventa','cliente')->findOrFail($id);

        return view('admin.ventas.show',compact('ventas'));
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $productos = Producto::where('empresa_id', Auth::user()->empresa_id)->get();
        $clientes = Cliente::where('empresa_id', Auth::user()->empresa_id)->get();
        $ventas = Venta::with('detallesventa','cliente')->findOrFail($id);
        return view('admin.ventas.edit', compact('ventas','productos','clientes'));
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
            'precio_total'=>'required'
            
        ]);

        $venta = venta::find($id);
        $venta->fecha = $request->fecha;  
        $venta->precio_total = $request->precio_total;
        $venta->cliente_id = $request->id_cliente;
        $venta->empresa_id = Auth::user()->empresa_id;
        $venta->save();

        return redirect()->route('admin.ventas.index')
        ->with('mensaje','se actualizo la venta de la manera correcta')
        ->with('icono','success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $venta = Venta::find($id);

        foreach ($venta->detallesventa as $detalle) {
            $producto = Producto::find($detalle->producto_id);
            $producto->stock += $detalle->cantidad;
            $producto->save();
        }

        $venta->detallesventa()->delete(); //borrar los detalles

        $venta->delete(); // borrar la compra

        return redirect()->route('admin.ventas.index')
        ->with('mensaje','se elimino la compra de la manera correcta')
        ->with('icono','success');
    }

    public function reporte(){
        $empresa = Empresa::where('id', Auth::user()->empresa->id)->get()->first();
        $ventas = Venta::with('cliente')
            ->where('empresa_id', Auth::user()->empresa_id)->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.ventas.reporte', compact('ventas','empresa')) ->setPaper('letter','landscape');
        return $pdf->stream();
    }
}
