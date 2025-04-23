<?php

namespace App\Http\Controllers;

use App\Models\Compras;
use App\Models\Empresa;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProveedorController extends Controller
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
        $proveedores = Proveedor::where('empresa_id',Auth::user()->empresa_id)->get();
        $empresa = Empresa::where('id', Auth::user()->empresa_id)->first();
        return view('admin.proveedores.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::where('empresa_id', Auth::user()->empresa_id)->get();
        $proveedor = Proveedor::where('empresa_id', Auth::user()->empresa_id)->get();

        return view('admin.proveedores.create', compact('productos','proveedor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'empresa'=>'required',
            'direccion'=>'required',
            'telefono'=>'required',
            'email'=>'required',
            'nombre'=>'required',
            'celular'=>'required',
            
        ]);

        $proveedor = new Proveedor();
        $proveedor->empresa = $request->empresa;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->email = $request->email;
        $proveedor->nombre = $request->nombre;
        $proveedor->celular = $request->celular;
        $proveedor->empresa_id = Auth::user()->empresa_id;

        $proveedor->save();

        return redirect()->route('admin.proveedores.index')
        ->with('mensaje','se registro el proveedor de la manera correcta')
        ->with('icono','success');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $proveedores = Proveedor::find($id);
        return view('admin.proveedores.show', compact('proveedores'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $proveedores = Proveedor::find($id);
        return view('admin.proveedores.edit', compact('proveedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'empresa'=>'required',
            'direccion'=>'required',
            'telefono'=>'required',
            'email'=>'required',
            'nombre'=>'required',
            'celular'=>'required',
            
        ]);

        $proveedor = Proveedor::find($id);
        $proveedor->empresa = $request->empresa;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->email = $request->email;
        $proveedor->nombre = $request->nombre;
        $proveedor->celular = $request->celular;
        $proveedor->empresa_id = Auth::user()->empresa_id;

        $proveedor->save();

        return redirect()->route('admin.proveedores.index')
        ->with('mensaje','se actualizo el proveedor de la manera correcta')
        ->with('icono','success');

    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Proveedor::destroy($id);

        return redirect()->route('admin.proveedores.index')
        ->with('mensaje','se elimino el proveedor de la manera correcta')
        ->with('icono','success');
    }

    public function reporte(){
        $empresa = Empresa::where('id', Auth::user()->empresa->id)->get()->first();
        $proveedores = Proveedor::where('empresa_id',Auth::user()->empresa_id)->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.proveedores.reporte', compact('proveedores','empresa'))->setPaper('letter','landscape');
        return $pdf->stream();
    }
}
