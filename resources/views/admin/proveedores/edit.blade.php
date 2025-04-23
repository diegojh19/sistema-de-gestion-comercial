@extends('adminlte::page')

@section('content_header')
    <h1><b>Editar proveedor</b></h1>
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
                <form action="{{url('admin/proveedores',$proveedores->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="empresa">Nombre de la empresa</label> <b>*</b>
                                <input type="text" name="empresa" value="{{$proveedores->empresa}}" class="form-control" required>
                                @error('empresa')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="direccion">Dirección</label> <b>*</b>
                                <input type="text" name="direccion" value="{{$proveedores->direccion}}" class="form-control" required>
                                @error('direccion')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label> <b>*</b>
                                <input type="text" name="telefono" value="{{$proveedores->telefono}}" class="form-control" required>
                                @error('telefono')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email</label> <b>*</b>
                                <input type="email" name="email" value="{{$proveedores->email}}" class="form-control" required>
                                @error('email')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre"> Nombre del proveedor</label> <b>*</b>
                                <input type="text" name="nombre" value="{{$proveedores->nombre}}" class="form-control" required>
                                @error('nombre')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="celular"> Celular del proveedor</label> <b>*</b>
                                <input type="text" name="celular" value="{{$proveedores->celular}}"" class="form-control" required>
                                @error('celular')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        
                    </div>

                    

                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url('admin/proveedores')}}" class="btn btn-secondary">Cancelar</a>
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