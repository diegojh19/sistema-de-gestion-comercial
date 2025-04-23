@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1><b>Listado de Usuarios</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Usuarios Registrados</h3>
                        <div class="card-tools">
                            <a href="{{url('admin/usuarios/reporte')}}" class="btn btn-danger" target="_blank"><i class="fa fa-file-pdf"></i>
                                Reporte
                            </a>
                            <a href="{{url('admin/usuarios/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>
                                Registrar nuevo
                            </a>
                        </div>
                </div>

                <div class="card-body">
                    <table id="example"class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th style="text-align: center">Nro</th>
                                <th>Rol del usuario</th>
                                <th>Nombre del usuario</th>
                                <th>Email usuario</th>
                                <th style="text-align: center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $contador =1; ?>
                        @foreach($usuarios as $usuario)
                            <tr>
                                <td style="text-align: center">{{$contador++}}</td>
                            
                                <td>{{$usuario->roles->pluck('name')->implode(', ')}}</td>
                                <td>{{$usuario->name}}</td>
                                <td>{{$usuario->email}}</td>

   
                                <td style="text-align: center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{url('admin/usuarios/'.$usuario->id)}}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="{{url('admin/usuarios/'.$usuario->id.'/edit')}}" class="btn btn-success"><i class="fas fa-pencil"></i></a>
                                        
                                        @if ($usuario->name !== 'Admin')
                                        <form action="{{url('admin/usuarios',$usuario->id)}}" method="post"
                                            onclick="preguntar{{$usuario->id}}(event)" id="miformulario{{$usuario->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                        <script>
                                            function preguntar{{$usuario->id}}(event){
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
                                                        var form = $('#miformulario{{$usuario->id}}');
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
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ Usuarios",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando Usuarios del _START_ al _END_ de un total de _TOTAL_ Usuarios",
                "sInfoEmpty": "Mostrando Usuarios del 0 al 0 de un total de 0 Usuarios",
                "sInfoFiltered": "(filtrado de un total de _MAX_ Usuarios)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sPrevious": "Anterior",
                    "sNext": "Siguiente",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            "pageLength": 10  // Número de filas por página
           
        });
    });
</script>
@stop