@extends('adminlte::page')

@section('content_header')
    <h1><b>Editar usuario</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title">Complete los campos</h3>
                    
            </div>

            <div class="card-body">
                <form action="{{url('admin/usuarios',$usuario->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="role">Nombre del Rol</label>
                                <select name="role" id="select_pais" class="form-control">
                                    @foreach ($roles as $role )
                                        <option value="{{$role->name}}" {{$role->name == $usuario->roles->pluck('name')->implode(', ') ? 'selected':''}}>{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Nombre del usuario</label>
                                @if ($usuario->name === 'Admin')
                                <input type="text"  value="{{$usuario->name}}" class="form-control" disabled>
                                <input type="text" name="name" value="{{$usuario->name}}" class="form-control" hidden>

                                @else
                                <input type="text" name="name" value="{{$usuario->name}}" class="form-control" required>

                                @endif
                                
                                @error('name')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" value="{{$usuario->email}}" class="form-control" required>
                                @error('email')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" name="password" value="{{old('password')}}" class="form-control" >
                                @error('password')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password_confirmation"> Confirmar Contraseña</label>
                                <input type="password" name="password_confirmation" value="{{old('password_confirmation')}}" class="form-control" >
                                @error('password_confirmation')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    

                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url('admin/usuarios')}}" class="btn btn-secondary">Cancelar</a>
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