@extends('adminlte::page')

@section('content_header')
    <h1><b>Categoria registrada</b></h1>
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
                                <label for="name">Nombre de la categoria</label>
                                <p>{{$categorias->name}}</p>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="descripcion">Descripcion</label>
                                <p>{{$categorias->descripcion}}</p>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url('admin/categorias')}}" class="btn btn-secondary">Volver</a>
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