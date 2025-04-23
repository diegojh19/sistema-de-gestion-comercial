<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class EmpresaController extends Controller
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
       
        $paises = DB::table('countries')->get();
        $ciudades = DB::table('cities')->get();
        $estados = DB::table('states')->get();
        $monedas = DB::table('currencies')->get();
        return view('admin.empresas.create', compact('paises','estados','ciudades','monedas'));
    }

    public function buscar_estado($id_pais){
        //echo $id_pais;
        try{
            $estados = DB::table('states')->where('country_id', $id_pais)->get();
            return view('admin.empresas.cargar_estados', compact('estados'));
        }catch(\Exception $exception){
            return response()->json(['mensaje'=>'Error']);
        }

    }

    public function buscar_ciudades($id_estado){
        //echo $id_estado;
        try{
            $ciudades = DB::table('cities')->where('state_id', $id_estado)->get();
            return view('admin.empresas.cargar_ciudades', compact('ciudades'));
        }catch(\Exception $exception){
            return response()->json(['mensaje'=>'Error']);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_empresa'=>'required',
            'tipo_empresa'=>'required',
            'nit'=>'required|unique:empresas',
            'telefono'=>'required',
            'correo'=>'required|unique:empresas',
            'cantidad_impuesto'=>'required',
            'nombre_impuesto'=>'required',
            'moneda'=>'required',
            'direccion'=>'required',
            'codigo_postal'=>'required',
            'logo'=> 'required|image|mimes:jpeg,png,jpg,gif',
            
        ]);

        $empresa = new Empresa();

        $empresa->pais = $request->pais;
        $empresa->nombre_empresa = $request->nombre_empresa;
        $empresa->tipo_empresa = $request->tipo_empresa;
        $empresa->nit = $request->nit;
        $empresa->telefono = $request->telefono;
        $empresa->correo = $request->correo;
        $empresa->cantidad_impuesto = $request->cantidad_impuesto;
        $empresa->nombre_impuesto = $request->nombre_impuesto;
        $empresa->moneda = $request->moneda;
        $empresa->direccion = $request->direccion;
        $empresa->ciudad = $request->ciudad;
        $empresa->departamento = $request->departamento;
        $empresa->codigo_postal = $request->codigo_postal;
        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            // Verificar si la carpeta 'logos' existe y crearla si no existe
            if (!Storage::disk('public')->exists('logos')) {
                Storage::disk('public')->makeDirectory('logos');
            }
        
            // Guardar el archivo
            $empresa->logo = $request->file('logo')->store('logos', 'public');
        } else {
            return back()->withErrors(['logo' => 'El logo debe ser una imagen válida.']);
        }

        $empresa->save();

        $usuario = new User();
        $usuario->name = "Admin";
        $usuario->email = $request->correo;
        $usuario->password = Hash::make($request['nit']);
        $usuario->empresa_id = $empresa->id;
        $usuario->save();

        
        $rol = new Role();
        $rol->name = "ADMINISTRADOR";
        $rol->empresa_id = $empresa->id;
        $rol->save();

        $usuario->assignRole($rol->id);

        $role = Role::find($rol->id);
        $todos_los_permisos = Permission::pluck('id')->toArray();
        $role->permissions()->sync($todos_los_permisos);

        Auth::login($usuario);

        
        return redirect()->route('admin.index')
        ->with('mensaje','se registro la empresa de la manera correcta')
        ->with('icono','success');
 
    }

    /**
     * Display the specified resource.
     */
    public function show(Empresa $empresa)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empresa $empresa)
    {
        $paises = DB::table('countries')->get();
        //$ciudades = DB::table('cities')->get();
        $estados = DB::table('states')->get();
        $monedas = DB::table('currencies')->get();
        $empresa_id = Auth::user()->empresa_id;
        $empresa = Empresa::where('id',$empresa_id)->first();
        $departamento = DB::table('states')->where('country_id',$empresa->pais)->get();
        $ciudades = DB::table('cities')->where('state_id',$empresa->departamento)->get();

        return view('admin.configuraciones.edit', compact('paises','estados','ciudades','monedas','empresa','departamento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validación de los datos
    $request->validate([
        'nombre_empresa' => 'required',
        'tipo_empresa' => 'required',
        'nit' => 'required|unique:empresas,nit,' . $id,
        'telefono' => 'required',
        'correo' => 'required|unique:empresas,correo,' . $id,
        'cantidad_impuesto' => 'required',
        'nombre_impuesto' => 'required',
        'moneda' => 'required',
        'direccion' => 'required',
        'codigo_postal' => 'required',
    ]);

    // Buscar la empresa
    $empresa = Empresa::find($id);

    // Actualizar los datos de la empresa
    $empresa->pais = $request->pais;
    $empresa->nombre_empresa = $request->nombre_empresa;
    $empresa->tipo_empresa = $request->tipo_empresa;
    $empresa->nit = $request->nit;
    $empresa->telefono = $request->telefono;
    $empresa->correo = $request->correo;
    $empresa->cantidad_impuesto = $request->cantidad_impuesto;
    $empresa->nombre_impuesto = $request->nombre_impuesto;
    $empresa->moneda = $request->moneda;
    $empresa->direccion = $request->direccion;
    $empresa->ciudad = $request->ciudad;
    $empresa->departamento = $request->departamento;
    $empresa->codigo_postal = $request->codigo_postal;

    
    if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
        
        if ($empresa->logo && Storage::exists('public/' . $empresa->logo)) {
            Storage::delete('public/' . $empresa->logo);
        }

       
        $empresa->logo = $request->file('logo')->store('logos', 'public');
    }

    
    $empresa->save();

    
    $usuario_id = Auth::user()->id;
    $usuario = User::find($usuario_id);
    $usuario->name = "Admin";
    $usuario->email = $request->correo;
    $usuario->password = Hash::make($request['nit']);
    $usuario->empresa_id = $empresa->id;
    $usuario->save();

    
    return redirect()->route('admin.index')
        ->with('mensaje', 'Se modificaron los datos de la empresa correctamente.')
        ->with('icono', 'success');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empresa $empresa)
    {
        //
    }
}
