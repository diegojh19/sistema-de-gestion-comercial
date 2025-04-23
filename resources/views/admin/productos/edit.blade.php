@extends('adminlte::page')

@section('content_header')
    <h1><b>Editar producto</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Complete los campos</h3>
                    
            </div>

            <div class="card-body">
                <form action="{{(url('/admin/productos',$productos->id))}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="categoria_id">Categoria</label>
                                        <select name="categoria_id" id="" class="form-control">
                                            @foreach ($categorias as $categoria)
                                              <option value="{{$categoria->id}}" {{$categoria->id == $productos->categoria_id ? 'selected': ''}}>{{$categoria->name}}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="codigo">Código</label><b>*</b>
                                        <input type="text" name="codigo" value="{{$productos->codigo}}" class="form-control" required>
                                        @error('codigo')
                                            <small class="text-danger" style="color::red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nombre">Nombre Producto</label><b>*</b>
                                        <input type="text" name="nombre" value="{{$productos->nombre}}" class="form-control" required>
                                        @error('nombre')
                                            <small class="text-danger" style="color::red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Descripcion</label>
                                        <textarea class="form-control" name="descripcion"  id="" cols="30" rows="3"> {{$productos->descripcion}}</textarea>                                        @error('codigo')
                                            <small class="text-danger" style="color::red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="stock">Stock</label><b>*</b>
                                        <input type="number" name="stock" value="{{$productos->stock}}" class="form-control" required>
                                        @error('stock')
                                            <small class="text-danger" style="color::red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="stock_minimo">Stock Mínimo</label><b>*</b>
                                        <input type="number" name="stock_minimo" value="{{$productos->stock_minimo}}" class="form-control" required>
                                        @error('stock_minimo')
                                            <small class="text-danger" style="color::red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="stock_maximo">Stock Máximo</label><b>*</b>
                                        <input type="number" name="stock_maximo" value="{{$productos->stock_maximo}}" class="form-control" required>
                                        @error('stock_maximo')
                                            <small class="text-danger" style="color::red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            
        
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="precio_compra">Precio Compra</label><b>*</b>
                                        <input type="text" name="precio_compra" value="{{$productos->precio_compra}}" class="form-control" required>
                                        @error('precio_compra')
                                            <small class="text-danger" style="color::red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="precio_venta">Precio Venta</label><b>*</b>
                                        <input type="text" name="precio_venta" value="{{$productos->precio_venta}}" class="form-control" required>
                                        @error('precio_venta')
                                            <small class="text-danger" style="color::red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="fecha_ingreso">fecha Ingreso</label><b>*</b>
                                        <input type="date" name="fecha_ingreso" value="{{$productos->fecha_ingreso}}" class="form-control" required>
                                        @error('fecha_ingreso')
                                            <small class="text-danger" style="color::red">{{$message}}</small>
                                        @enderror
                                    </div>
    
                        </div>
                        </div>
                    </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="file">Imagen</label>
                                    <input type="file" id="file" name="imagen" class="form-control" accept="image/jpeg, image/png, image/gif">
                                    @error('imagen')
                                        <small class="text-danger" style="color::red">{{$message}}</small>
                                        @enderror
                                    <br>
                                    <center><output id="list"> <img src="{{asset('storage/'.$productos->imagen)}}" width="80px" alt="imagen"></output></center>
                                    <script>
                                        function archivo(evt) {
                                            var files = evt.target.files;
                                            var output = document.getElementById("list");
                                            output.innerHTML = ''; // Limpiar la previsualización anterior

                                            for (var i = 0, f; f = files[i]; i++) {
                                                if (!f.type.match('image.*')) {
                                                    continue; // Ignorar archivos que no sean imágenes
                                                }

                                                var reader = new FileReader();
                                                reader.onload = (function(theFile) {
                                                    return function(e) {
                                                        // Mostrar la previsualización de la imagen
                                                        output.innerHTML = ['<img class="thumb thumbnail" src="', e.target.result, '" width="200" height="200" title="', escape(theFile.name), '"/>'].join('');
                                                    };
                                                })(f);
                                                reader.readAsDataURL(f);
                                            }
                                        }
                                        document.getElementById('file').addEventListener('change', archivo, false);
                                    </script>
                                </div>
                            </div>
                        
                    </div>
                    

                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url('admin/productos')}}" class="btn btn-secondary">Cancelar</a>
                              <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Modificar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

@stop