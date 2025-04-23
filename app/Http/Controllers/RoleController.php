<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
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
        $roles = Role::where('empresa_id', Auth::user()->empresa_id)->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rol = new Role();

        $rol->name = $request->name;
        $rol->guard_name = "web";
        $rol->empresa_id = Auth::user()->empresa_id;
        $rol->save();

        return redirect()->route('admin.roles.index')
        ->with('mensaje','se registro el rol de la manera correcta')
        ->with('icono','success');

    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $roles = Role::findOrFail($id);
        return view('admin.roles.show', compact('roles'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $roles = Role::findOrFail($id);
        return view('admin.roles.edit', compact ('roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $request->validate([
            
            'name'=>'required|unique:roles,name,'.$id
        ]);

        $rol =  Role::find($id);

        $rol->name = $request->name;
        $rol->guard_name = "web";
 
        $rol->save();

        return redirect()->route('admin.roles.index')
        ->with('mensaje','se modifico el rol de la manera correcta')
        ->with('icono','success');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::destroy($id);

        return redirect()->route('admin.roles.index')
        ->with('mensaje','se elimino el rol de la manera correcta')
        ->with('icono','success');
    }

    public function reporte(){
        $empresa = Empresa::where('id', Auth::user()->empresa->id)->get()->first();
        $roles = Role::where('empresa_id', Auth::user()->empresa_id)->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.roles.reporte', compact('roles','empresa'))->setPaper('letter','landscape');
        return $pdf->stream();
    }

    public function asignar($id){
        $rol = Role::find($id);
        $permisos = Permission::all()->groupBy(function($permiso){
            if(stripos($permiso->name, 'config') !== false){
                return 'Configuración';
            } elseif(stripos($permiso->name, 'rol') !== false){
                return 'Roles';
            } elseif(stripos($permiso->name, 'permi') !== false){
                return 'Permisos';
            }  elseif(stripos($permiso->name, 'usu') !== false){
                return 'Usuarios';
            }  elseif(stripos($permiso->name, 'cat') !== false){
                return 'Categorias';
            }  elseif(stripos($permiso->name, 'prod') !== false){
                return 'Productos';
            }  elseif(stripos($permiso->name, 'prov') !== false){
                return 'Proveedores';
            }  elseif(stripos($permiso->name, 'comp') !== false){
                return 'Compras';
            }    elseif(stripos($permiso->name, 'cli') !== false){
                    return 'Clientes';
            }  elseif(stripos($permiso->name, 'ven') !== false){
                return 'Ventas';
            }  elseif(stripos($permiso->name, 'arq') !== false){
                return 'Arqueo';
            }      
        });
        return view('admin.roles.asignar', compact('permisos','rol'));
    }

    public function update_asignar(Request $request, $id){
         //$datos = request()->all();
        //return response()->json($datos);

        $rol = Role::find($id);
        $rol->permissions()->sync($request->input('permisos'));

        return redirect()->back()->with('mensaje','se actualizo los permisos a el rol de la manera correcta')
        ->with('icono','success');
    }


}
