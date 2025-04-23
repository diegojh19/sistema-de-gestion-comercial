@extends('adminlte::page')


@section('content_header')
    <h1>Bienvenido {{$empresa->nombre_empresa}}</h1>
    <hr>
@stop

@section('content')
   <div class="row">
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <a href="{{url('/admin/roles')}}" class="info-box-icon bg-info">
            <span><i class="fas fa-user-check"></i></span>
          </a>
          <div class="info-box-content">
            <span class="info-box-text">Roles registrado</span>
            <span class="info-box-number">{{$total_roles}} Roles</span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <a href="{{url('/admin/usuarios')}}" class="info-box-icon bg-primary">
            <span><i class="fas fa-users"></i></span>
          </a>
          <div class="info-box-content">
            <span class="info-box-text">Usuarios registrado</span>
            <span class="info-box-number">{{$total_usuarios}} Usuarios</span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <a href="{{url('/admin/categorias')}}" class="info-box-icon bg-success">
            <span><i class="fas fa-tags"></i></span>
          </a>
          <div class="info-box-content">
            <span class="info-box-text">Categorias registrado</span>
            <span class="info-box-number">{{$total_categorias}} categorias</span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <a href="{{url('/admin/productos')}}" class="info-box-icon bg-warning">
            <span><i class="fas fa-list"></i></span>
          </a>
          <div class="info-box-content">
            <span class="info-box-text">Productos registrado</span>
            <span class="info-box-number">{{$total_productos}} Productos</span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <a href="{{url('/admin/proveedores')}}" class="info-box-icon bg-danger">
            <span><i class="fas fa-list"></i></span>
          </a>
          <div class="info-box-content">
            <span class="info-box-text">Proveedores registrado</span>
            <span class="info-box-number">{{$total_proveedor}} Proveedor</span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <a href="{{url('/admin/compras')}}" class="info-box-icon bg-dark">
            <span><i class="fas fa-shopping-cart"></i></span>
          </a>
          <div class="info-box-content">
            <span class="info-box-text">Compras registradas</span>
            <span class="info-box-number">{{$total_compras}} Compras</span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <a href="{{url('/admin/clientes')}}" class="info-box-icon bg-info">
            <span><i class="fas fa-users"></i></span>
          </a>
          <div class="info-box-content">
            <span class="info-box-text">Clientes registradas</span>
            <span class="info-box-number">{{$total_clientes}} Clientes</span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <a href="{{url('/admin/arqueos')}}" class="info-box-icon bg-primary">
            <span><i class="fas fa-cash-register"></i></span>
          </a>
          <div class="info-box-content">
            <span class="info-box-text">Arqueos registrados</span>
            <span class="info-box-number">{{$total_arqueos}} Arqueos</span>
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

@if( (($message = Session::get('mensaje')) && ($icono = Session::get('icono'))) )
<script>
  swal.fire({
    position: "top-end",
    icon: "{{$icono}}",
    title: "{{$message}}",
    showConfirButton: false,
    timer: 1500
  });
</script>
@endif

@stop