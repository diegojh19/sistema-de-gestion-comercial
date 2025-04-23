@extends('adminlte::page')

@section('content_header')
    <h1><b>Datos del Proveedor</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Datos registrados</h3>
                    
            </div>

            <div class="card-body">
                
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="empresa">Nombre de la empresa</label>
                                <p>{{$proveedores->empresa}}</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="direccion">Dirección</label> 
                                <p>{{$proveedores->direccion}}</p>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label> 
                                <p>{{$proveedores->telefono}}</p>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email</label> 
                                <p>{{$proveedores->email}}</p>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre"> Nombre del proveedor</label> 
                                <p>{{$proveedores->nombre}}</p>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="celular"> Celular del proveedor</label> 
                                <p>{{$proveedores->celular}}</p>

                            </div>
                        </div>

                        
                    </div>

                    

                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url('admin/proveedores')}}" class="btn btn-secondary">Volver</a>
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