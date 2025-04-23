@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1><b>Listado de Roles</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Roles Registrados</h3>
                        <div class="card-tools">
                            <a href="{{url('admin/roles/reporte')}}" class="btn btn-danger" target="_blank"><i class="fa fa-file-pdf"></i>
                                Reporte
                            </a>
                            <a href="{{url('admin/roles/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>
                                Registrar nuevo
                            </a>
                        </div>
                </div>

                <div class="card-body">
                    <table id="example1"class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th style="text-align: center">Nro</th>
                                <th style="text-align: center">Nombre del rol</th>
                                <th style="text-align: center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $contador =1; ?>
                        @foreach($roles as $role)
                            <tr>
                                <td style="text-align: center">{{$contador++}}</td>
                            
                                <td style="text-align: center">{{$role->name}}</td>
   
                                <td style="text-align: center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{url('admin/roles/'.$role->id)}}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        @if ($role->name !== 'ADMINISTRADOR')
                                        <a href="{{url('admin/roles/'.$role->id.'/edit')}}" class="btn btn-success"><i class="fas fa-pencil"></i></a>
                                        @endif

                                        


                                        <a href="{{url('admin/roles/'.$role->id.'/asignar')}}" class="btn btn-warning"><i class="fas fa-check"></i></a>

                                        @if ($role->name !== 'ADMINISTRADOR')
                                        <form action="{{url('admin/roles',$role->id)}}" method="post"
                                            onclick="preguntar{{$role->id}}(event)" id="miformulario{{$role->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                        <script>
                                            function preguntar{{$role->id}}(event){
                                                event.preventDefault();
                                                Swal.fire({
                                                title: "Desea eliminar este registro?",
                                                text: '',
                                                icon: 'question',
                                                showDenyButton: true,
                                                confirmButtonText: "Eliminar",
                                                confirmButtonColor: '#270a0a',
                                                denyButtonText: 'Cancelar',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        var form = $('#miformulario{{$role->id}}');
                                                        form.submit();
                                                    }
                                                });
                                            }
                                        </script>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                            
                        </tbody>
                        
                    </table>
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