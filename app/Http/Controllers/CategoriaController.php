<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
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
        $categorias = Categoria::where('empresa_id',Auth::user()->empresa_id)->get();
        return view('admin.categorias.index', compact('categorias'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:250|unique:categorias',
            'descripcion'=>'required',
        ]);

        $categoria = new Categoria();
        $categoria->name = $request->name;
        $categoria->descripcion = $request->descripcion;
        $categoria->empresa_id = Auth::user()->empresa_id;
        $categoria->save();


        return redirect()->route('admin.categorias.index')
        ->with('mensaje','se registro la categoria de la manera correcta')
        ->with('icono','success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categorias = Categoria::find($id);
        return view('admin.categorias.show', compact('categorias'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categorias = Categoria::find($id);
        return view('admin.categorias.edit', compact ('categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|max:250|unique:categorias,name,'.$id,
            'descripcion'=>'required',
        ]);

        $categoria =  Categoria::find($id);
        $categoria->name = $request->name;
        $categoria->descripcion = $request->descripcion;
        $categoria->empresa_id = Auth::user()->empresa_id;
        $categoria->save();


        return redirect()->route('admin.categorias.index')
        ->with('mensaje','se actualizo la categoria de la manera correcta')
        ->with('icono','success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Categoria::destroy($id);

        return redirect()->route('admin.categorias.index')
        ->with('mensaje','se elimino la categoria de la manera correcta')
        ->with('icono','success');
    }

    
    public function reporte(){
        $empresa = Empresa::where('id', Auth::user()->empresa->id)->get()->first();
        $categorias = Categoria::where('empresa_id',Auth::user()->empresa_id)->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.categorias.reporte', compact('categorias','empresa')) ->setPaper('letter','landscape');
        return $pdf->stream();
    }
}
