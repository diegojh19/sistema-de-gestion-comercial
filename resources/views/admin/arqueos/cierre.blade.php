@extends('adminlte::page')

@section('content_header')
    <h1><b>Cierre de arqueo</b></h1>
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
                <form action="{{ route('admin.arqueos.store_cierre') }}" method="POST">
                    @csrf
                        <input type="text" value="{{$arqueos->id}}" name="id" hidden>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fecha_apertura">Fecha Apertura</label> 
                                    <input type="datetime-local" name="fecha_apertura" value="{{$arqueos->fecha_apertura,old('fecha_apertura')}}" class="form-control" disabled>
                                    @error('fecha_apertura')
                                        <small class="text-danger" style="color::red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="monto_inicial">Monto Inicial</label>
                                    <input type="text" name="monto_inicial" value="{{$arqueos->monto_inicial,old('monto_inicial')}}" class="form-control" disabled>
                                    @error('monto')
                                        <small class="text-danger" style="color::red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fecha_cierre">Fecha cierre</label> 
                                    <input type="datetime-local" name="fecha_cierre" 
                                           value="{{ old('fecha_cierre', \Carbon\Carbon::parse($arqueos->fecha_cierre)->format('Y-m-d\TH:i') ?? '') }}" 
                                           class="form-control">
                                    @error('fecha_cierre')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="monto_final">Monto Final</label>
                                    <input type="text" name="monto_final" value="{{old('monto_final')}}" class="form-control">
                                    @error('monto')
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