@extends('adminlte::page')

@section('content_header')
    <h1><b>Registro de un nuevo Arqueo</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Complete los campos</h3>
                    
            </div>

            <div class="card-body">
                <form action="{{(url('/admin/arqueos/create'))}}" method="post">
                    @csrf
                    
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fecha_apertura">Fecha Apertura</label> <b>*</b>
                                    <input type="datetime-local" name="fecha_apertura"
                                    value="{{ old('fecha_apertura', \Carbon\Carbon::now()->format('Y-m-d\TH:i')) }}"
                                    class="form-control" required>                                    @error('fecha_apertura')
                                        <small class="text-danger" style="color::red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="monto_inicial">Monto Inicial</label>
                                    <input type="text" name="monto_inicial" value="{{old('monto_inicial')}}" class="form-control">
                                    @error('monto_inicial')
                                        <small class="text-danger" style="color::red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <input type="text" name="descripcion" value="{{old('descripcion')}}" class="form-control" required>
                                @error('descripcion')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url('admin/arqueos')}}" class="btn btn-secondary">Cancelar</a>
                              <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Registrar</button>
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