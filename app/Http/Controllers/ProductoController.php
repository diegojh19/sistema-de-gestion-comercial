<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
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
        $productos = Producto::with('categoria')->where('empresa_id',Auth::user()->empresa_id)->get();;
        return view('admin.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::where('empresa_id',Auth::user()->empresa_id)->get();
        return view('admin.productos.create', compact('categorias'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo'=>'required|unique:productos,codigo',
            'nombre'=>'required',
            'stock'=>'required',
            'stock_minimo'=>'required',
            'stock_maximo'=>'required',
            'precio_compra'=>'required',
            'precio_venta'=>'required',
            'fecha_ingreso'=>'required',
        ]);

        $productos = new Producto();
        $productos->categoria_id = $request->categoria_id;
        $productos->codigo = $request->codigo;
        $productos->nombre = $request->nombre;
        $productos->descripcion = $request->descripcion;
        $productos->stock = $request->stock;
        $productos->stock_minimo = $request->stock_minimo;
        $productos->stock_maximo = $request->stock_maximo;
        $productos->precio_compra = $request->precio_compra;
        $productos->precio_venta = $request->precio_venta;
        $productos->fecha_ingreso = $request->fecha_ingreso;
        $productos->empresa_id = Auth::user()->empresa_id;

        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            // Verificar si la carpeta 'productos' existe y crearla si no existe
            if (!Storage::disk('public')->exists('productos')) {
                Storage::disk('public')->makeDirectory('productos');
            }
        
            // Guardar el archivo
            $productos->imagen = $request->file('imagen')->store('productos', 'public');
        } else {
            return back()->withErrors(['imagen' => 'La imagen debe ser una imagen válida.']);
        }
        $productos->save();

        return redirect()->route('admin.productos.index')
        ->with('mensaje','se registro el producto de la manera correcta')
        ->with('icono','success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $productos = Producto::find($id);
        return view('admin.productos.show', compact('productos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $productos = Producto::find($id);
        $categorias = Categoria::all();
        return view('admin.productos.edit', compact('productos','categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo'=>'required|unique:productos,codigo,' . $id,
            'nombre'=>'required',
            'stock'=>'required',
            'stock_minimo'=>'required',
            'stock_maximo'=>'required',
            'precio_compra'=>'required',
            'precio_venta'=>'required',
            'fecha_ingreso'=>'required',
        ]);

        $productos = Producto::find($id);
        $productos->categoria_id = $request->categoria_id;
        $productos->codigo = $request->codigo;
        $productos->nombre = $request->nombre;
        $productos->descripcion = $request->descripcion;
        $productos->stock = $request->stock;
        $productos->stock_minimo = $request->stock_minimo;
        $productos->stock_maximo = $request->stock_maximo;
        $productos->precio_compra = $request->precio_compra;
        $productos->precio_venta = $request->precio_venta;
        $productos->fecha_ingreso = $request->fecha_ingreso;
        $productos->empresa_id = Auth::user()->empresa_id;

        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
        
            if ($productos->imagen && Storage::exists('public/' . $productos->imagen)) {
                Storage::delete('public/' . $productos->imagen);
            }
    
           
            $productos->imagen = $request->file('imagen')->store('productos', 'public');
        }

        $productos->save();

        return redirect()->route('admin.productos.index')
        ->with('mensaje','se actualizo el producto de la manera correcta')
        ->with('icono','success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $productos = Producto::find($id);
        Producto::destroy($id);
        Storage::delete('public/' . $productos->imagen);

        return redirect()->route('admin.productos.index')
        ->with('mensaje','se elimino el producto de la manera correcta')
        ->with('icono','success');
    }

    public function reporte(){
        $empresa = Empresa::where('id', Auth::user()->empresa->id)->get()->first();
        $productos = Producto::where('empresa_id',Auth::user()->empresa_id)->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.productos.reporte', compact('productos','empresa'))
                ->setPaper('letter','landscape');
        return $pdf->stream();
    }
}
