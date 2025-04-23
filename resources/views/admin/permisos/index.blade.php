@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1><b>Listado de Permisos</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Permisos Registrados</h3>
                        <div class="card-tools">
                           <a href="{{url('/admin/permisos/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Crear Nuevo</a>
                            
                        </div>
                </div>

                <div class="card-body">
                    <table id="example" class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th style="text-align: center">Nro</th>
                                <th style="text-align: center">Nombre del Permiso</th>
                                <th style="text-align: center">Acciones</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php $contador =1; ?>
                        @foreach($permisos as $permiso)
                           
                        <tr>
                                <td style="text-align: center">{{$contador++}}</td>
                            
                                <td>{{$permiso->name}}</td>
                                <td style="text-align: center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{url('admin/permisos/'.$permiso->id)}}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="{{url('admin/permisos/'.$permiso->id.'/edit')}}" class="btn btn-success"><i class="fas fa-pencil"></i></a>
                                        <form action="{{url('admin/permisos',$permiso->id)}}" method="post"
                                            onclick="preguntar{{$permiso->id}}(event)" id="miformulario{{$permiso->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                        <script>
                                            function preguntar{{$permiso->id}}(event){
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
                                                        var form = $('#miformulario{{$permiso->id}}');
                                                        form.submit();
                                                    }
                                                });
                                            }
                                        </script>
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
                "sLengthMenu": "Mostrar _MENU_ Permisos",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando Permisos del _START_ al _END_ de un total de _TOTAL_ Permisos",
                "sInfoEmpty": "Mostrando Permisos del 0 al 0 de un total de 0 Permisos",
                "sInfoFiltered": "(filtrado de un total de _MAX_ Permisos)",
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
            "pageLength": 5  // Número de filas por página
           
        });
    });
</script>

@stop