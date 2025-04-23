<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
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
        $clientes =  Cliente::where('empresa_id',Auth::user()->empresa_id)->get();
        return view('admin.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        return view('admin.clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

        return redirect()->route('admin.clientes.index')
        ->with('mensaje','se registro el cliente de la manera correcta')
        ->with('icono','success');
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $clientes = Cliente::find($id);
        return view('admin.clientes.show', compact('clientes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $clientes = Cliente::find($id);
        return view('admin.clientes.edit', compact('clientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_cliente'=>'required',
            'nit_codigo'=>'required',
            'telefono'=>'required',
            'email'=>'required'
            
        ]);

        $clientes = Cliente::find($id);
        $clientes->nombre_cliente = $request->nombre_cliente;
        $clientes->nit_codigo = $request->nit_codigo;
        $clientes->telefono = $request->telefono;
        $clientes->email = $request->email;
        $clientes->empresa_id = Auth::user()->empresa_id;
        $clientes->save();

        return redirect()->route('admin.clientes.index')
        ->with('mensaje','se actualizo el cliente de la manera correcta')
        ->with('icono','success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       Cliente::destroy($id);

        return redirect()->route('admin.clientes.index')
        ->with('mensaje','se elimino el cliente de la manera correcta')
        ->with('icono','success');
    }

    public function reporte(){
        $empresa = Empresa::where('id', Auth::user()->empresa->id)->get()->first();
        $clientes =  Cliente::where('empresa_id',Auth::user()->empresa_id)->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.clientes.reporte', compact('clientes','empresa')) ->setPaper('letter','landscape');
        return $pdf->stream();
    }
}
