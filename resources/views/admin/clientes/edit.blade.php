@extends('adminlte::page')

@section('content_header')
    <h1><b>Modificar Cliente</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Complete los campos</h3>
                    
            </div>

            <div class="card-body">
                <form action="{{(url('/admin/clientes',$clientes->id))}}" method="post">
                    @csrf
                    @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre_cliente">Nombre del Cliente</label>
                                    <input type="text" name="nombre_cliente" value="{{$clientes->nombre_cliente}}" class="form-control" required>
                                    @error('nombre_cliente')
                                        <small class="text-danger" style="color::red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nit_codigo">Nit/Código del Cliente</label>
                                    <input type="text" name="nit_codigo" value="{{$clientes->nit_codigo}}" class="form-control" required>
                                    @error('nit_codigo')
                                        <small class="text-danger" style="color::red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" name="telefono" value="{{$clientes->telefono}}" class="form-control" required>
                                @error('telefono')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" value="{{$clientes->email}}" class="form-control" required>
                                @error('email')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url('admin/clientes')}}" class="btn btn-secondary">Cancelar</a>
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