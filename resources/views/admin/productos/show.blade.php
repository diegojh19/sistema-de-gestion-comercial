@extends('adminlte::page')

@section('content_header')
    <h1><b>Productos Registrado</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Datos Registrados</h3>
                    
            </div>

            <div class="card-body">
               
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="categoria_id">Categoria</label>
                                        <p>{{$productos->categoria->name}}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="codigo">Código</label>
                                        <p>{{$productos->codigo}}</p>

                                    </div>
                                </div>
        
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nombre">Nombre Producto</label>
                                        <p>{{$productos->nombre}}</p>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Descripcion</label>
                                        <p>{{$productos->descripcion}}</p>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="stock">Stock</label>
                                        <p>{{$productos->stock}}</p>

                                    </div>
                                </div>
        
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="stock_minimo">Stock Mínimo</label>
                                        <p>{{$productos->stock_minimo}}</p>

                                    </div>
                                </div>
        
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="stock_maximo">Stock Máximo</label>
                                        <p>{{$productos->stock_maximo}}</p>

                                    </div>
                                </div>
                            
        
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="precio_compra">Precio Compra</label>
                                        <p>{{$productos->precio_compra}}</p>

                                    </div>
                                </div>
        
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="precio_venta">Precio Venta</label>
                                        <p>{{$productos->precio_venta}}</p>

                                    </div>
                                </div>
        
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="fecha_ingreso">fecha Ingreso</label>
                                        <p>{{$productos->fecha_ingreso}}</p>
                                    </div>
                        </div>
                        </div>
                    </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="file">Imagen</label>
                                    <img src="{{asset('storage/'.$productos->imagen)}}" width="80px" alt="imagen">
                                </div>
                            </div>
                        
                    </div>
                    

                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url('admin/productos')}}" class="btn btn-secondary">Volver</a>
                            </div>
                        </div>
                    </div>
               
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