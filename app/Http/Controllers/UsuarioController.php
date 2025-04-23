<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
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
        $empresa_id = Auth::user()->empresa_id;
        $usuarios = User::where('empresa_id', $empresa_id)->get(); // muestra los usuarios unicos de la empresa
        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa_id = Auth::user()->empresa_id;
        $roles = Role::where('empresa_id', $empresa_id)->get();
        return view('admin.usuarios.create', compact('roles'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:250',
            'email'=>'required|max:250|unique:users',
            'password'=>'required|max:250|confirmed'
        ]);

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request['password']);
        $usuario->empresa_id = Auth::user()->empresa_id;
        $usuario->save();

        $usuario->assignRole($request->role);

        return redirect()->route('admin.usuarios.index')
        ->with('mensaje','se registro al usuario de la manera correcta')
        ->with('icono','success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $usuario = User::find($id);
        return view('admin.usuarios.show', compact ('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $usuario = User::find($id);
        $roles = Role::all();

        return view('admin.usuarios.edit', compact ('usuario','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $usuario =  User::find($id);

        $request->validate([
            'name'=>'required|max:250',
            'email'=>'required|max:250|unique:users,email,'.$usuario->id,
            'password'=>'nullable|max:250|confirmed'
        ]);

       
        $usuario->name = $request->name;
        $usuario->email = $request->email;

        if($request->filled('password')){
            $usuario->password = Hash::make($request['password']);
        }
        $usuario->empresa_id = Auth::user()->empresa_id;

        $usuario->save();

        $usuario->syncRoles($request->role);

        return redirect()->route('admin.usuarios.index')
        ->with('mensaje','se actualizo al usuario de la manera correcta')
        ->with('icono','success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::destroy($id);

        return redirect()->route('admin.usuarios.index')
        ->with('mensaje','se elimino el usuario de la manera correcta')
        ->with('icono','success');
    }

    public function reporte(){
        $empresa = Empresa::where('id', Auth::user()->empresa->id)->get()->first();
        $empresa_id = Auth::user()->empresa_id;
        $usuarios = User::where('empresa_id', $empresa_id)->get(); // muestra los usuarios unicos de la empresa
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.usuarios.reporte', compact('usuarios','empresa'))->setPaper('letter','landscape');
        return $pdf->stream();
    }
}
