@extends('adminlte::page')

@section('content_header')
    <h1><b>Registro de Ingresos-Egresos</b></h1>
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
                <form action="{{ route('admin.arqueos.store_ingreso_egreso') }}" method="POST">
                    @csrf
                        <input type="text" value="{{$arqueos->id}}" name="id" hidden>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fecha_apertura">Fecha Apertura</label> <b>*</b>
                                    <input type="datetime-local" name="fecha_apertura" value="{{$arqueos->fecha_apertura,old('fecha_apertura')}}" class="form-control" required>
                                    @error('fecha_apertura')
                                        <small class="text-danger" style="color::red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tipo">Tipo</label>
                                    <select name="tipo" id="" class="form-control">
                                        <option value="INGRESO">INGRESO</option>
                                        <option value="EGRESO">EGRESO</option>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="monto">Monto</label>
                                <input type="text" name="monto" value="{{old('monto')}}" class="form-control" required>
                                @error('monto')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

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