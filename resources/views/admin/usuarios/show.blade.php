@extends('adminlte::page')

@section('content_header')
    <h1><b>Usuarios Registrados</b></h1>
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="role">Nombre del Rol</label>
                                <p>{{$usuario->roles->pluck('name')->implode(', ')}}</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Nombre del usuario</label>
                                <p>{{$usuario->name}}</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <p>{{$usuario->email}}</p>
                            </div>
                        </div>
  
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url('admin/usuarios')}}" class="btn btn-secondary">Volver</a>
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