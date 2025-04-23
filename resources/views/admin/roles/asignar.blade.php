@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1><b>Asignar permisos al rol: {{$rol->name}}</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Permisos Registrados</h3>
                </div>

                <div class="card-body">
                    <form action="{{url('admin/roles/asignar',$rol->id)}}" method="POST">
                        @csrf
                        @method('PUT')

                        @foreach ($permisos as $modulo => $gruposPermisos)
                            <div class="col-md-4">
                                <h3>{{$modulo}}</h3>
                                @foreach ($gruposPermisos as $permiso )
                                    <div class="form-check">
                                        <input type="checkbox"  name="permisos[]" class="form-check-input" value="{{$permiso->id}}" {{$rol->hasPermissionTo($permiso->name) ? 'checked':''}}>
                                        <label for="" class="form-check-laber">{{$permiso->name}}</label>
                                    </div>
                                    
                                @endforeach
                                <hr>
                            </div>
                            
                        @endforeach

                    <hr>
                    <button type="submit" class="btn btn-primary">Guardar</button>
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