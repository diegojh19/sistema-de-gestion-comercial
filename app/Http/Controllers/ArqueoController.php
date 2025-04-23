<?php

namespace App\Http\Controllers;

use App\Models\Arqueo;
use App\Models\Empresa;
use App\Models\MovimientoCaja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArqueoController extends Controller
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
        $arqueos = Arqueo::with('movimientos')
            ->where('empresa_id',Auth::user()->empresa_id)
            ->get();

        foreach ($arqueos as $arqueo) {
            $arqueo->setAttribute('total_ingresos', $arqueo->movimientos->where('tipo', 'INGRESO')->sum('monto'));
            $arqueo->setAttribute('total_egresos', $arqueo->movimientos->where('tipo', 'EGRESO')->sum('monto'));
        }
        
        return view('admin.arqueos.index', compact('arqueos','arqueoAbierto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('admin.arqueos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha_apertura'=>'required',
        ]);

        $fechaOriginal = $request->input('fecha_apertura'); // Formato con T: 2025-04-14T23:03
        $fechaConvertida = Carbon::parse($fechaOriginal)->format('Y-m-d H:i:s'); // SQL-friendly

        $arqueos = new Arqueo();
        $arqueos->fecha_apertura = $fechaConvertida;
        $arqueos->monto_inicial = $request->monto_inicial;
        $arqueos->descripcion = $request->descripcion;
        $arqueos->empresa_id = Auth::user()->empresa_id;

        $arqueos->save();

        return redirect()->route('admin.arqueos.index')
        ->with('mensaje','se registro el arqueo de la manera correcta')
        ->with('icono','success');
    
    }


    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $arqueos = Arqueo::find($id);
        $movimientos = MovimientoCaja::where('arqueo_id',$id)->get();
        return view('admin.arqueos.show',compact('arqueos', 'movimientos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
        $arqueos = Arqueo::find($id);

        return view('admin.arqueos.edit',compact('arqueos'));
    }

    public function ingresoegreso($id){

        $arqueos = Arqueo::find($id);

        return view('admin.arqueos.ingreso-egreso', compact('arqueos'));
    }

    public function store_ingreso_egreso(Request $request){
        $request->validate([
            'monto'=>'required',
        ]);

        $movimiento = new MovimientoCaja();
        $movimiento->tipo = $request->tipo;
        $movimiento->monto = $request->monto;
        $movimiento->descripcion = $request->descripcion;
        $movimiento->arqueo_id = $request->id;

        $movimiento->save();

        return redirect()->route('admin.arqueos.index')
        ->with('mensaje','se registro el movimiento de la manera correcta')
        ->with('icono','success');
    }

    public function cierre($id){
        $arqueos = Arqueo::find($id);
        return view('admin.arqueos.cierre', compact('arqueos'));
    }

    public function store_cierre(Request $request){

        $arqueos = Arqueo::find($request->id);
        $fecha_cierre = $request->input('fecha_cierre');

// Asegúrate de que la fecha esté en el formato correcto
$fecha_cierre_formateada = \Carbon\Carbon::parse($fecha_cierre)->format('Y-m-d H:i');

// Actualiza el valor en la base de datos
$arqueos->fecha_cierre = $fecha_cierre_formateada; 
        $arqueos->monto_final = $request->monto_final; 
        $arqueos->save(); 

        return redirect()->route('admin.arqueos.index')
        ->with('mensaje','se registro el cierre de la manera correcta')
        ->with('icono','success');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha_apertura'=>'required',
        ]);

        $fechaOriginal = $request->input('fecha_apertura'); // Formato con T: 2025-04-14T23:03
        $fechaConvertida = Carbon::parse($fechaOriginal)->format('Y-m-d H:i:s'); // SQL-friendly


        $arqueos =  Arqueo::find($id);
        $arqueos->fecha_apertura = $fechaConvertida;
        $arqueos->monto_inicial = $request->monto_inicial;
        $arqueos->descripcion = $request->descripcion;
        $arqueos->empresa_id = Auth::user()->empresa_id;

        $arqueos->save();

        return redirect()->route('admin.arqueos.index')
        ->with('mensaje','se actualizo el arqueo de la manera correcta')
        ->with('icono','success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Arqueo $arqueo)
    {
        //
    }

    public function reporte(){

        $empresa = Empresa::where('id', Auth::user()->empresa->id)->get()->first();
        $arqueos = Arqueo::with('movimientos')
        ->where('empresa_id',Auth::user()->empresa_id)
        ->get();

        foreach ($arqueos as $arqueo) {
            $arqueo->setAttribute('total_ingresos', $arqueo->movimientos->where('tipo', 'INGRESO')->sum('monto'));
            $arqueo->setAttribute('total_egresos', $arqueo->movimientos->where('tipo', 'EGRESO')->sum('monto'));
        }
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.arqueos.reporte', compact('arqueos','empresa'))->setPaper('letter','landscape');
        return $pdf->stream();
    }
}
