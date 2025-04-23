@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1><b>Listado de Proveedores</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Proveedores Registrados</h3>
                        <div class="card-tools">
                            <a href="{{url('admin/proveedores/reporte')}}" class="btn btn-danger" target="_blank"><i class="fa fa-file-pdf"></i>
                                Reporte
                            </a>
                            <a href="{{url('admin/proveedores/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>
                                Registrar nuevo
                            </a>
                        </div>
                </div>

                <div class="card-body">
                    <table id="example1"class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th style="text-align: center">Nro</th>
                                <th>Empresa</th>
                                <th>Dirección</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Nombre del proveedor</th>
                                <th>Celular</th>
                                <th style="text-align: center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $contador =1; ?>
                        @foreach($proveedores as $proveedore)
                            <tr>
                                <td style="text-align: center">{{$contador++}}</td>
                                <td>{{$proveedore->empresa}}</td>
                                <td>{{$proveedore->direccion}}</td>
                                <td>{{$proveedore->telefono}}</td>
                                <td>{{$proveedore->email}}</td>
                                <td>{{$proveedore->nombre}}</td>
                                <td>{{$proveedore->celular}}</td>
 
                                <td style="text-align: center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{url('admin/proveedores/'.$proveedore->id)}}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="{{url('admin/proveedores/'.$proveedore->id.'/edit')}}" class="btn btn-success"><i class="fas fa-pencil"></i></a>
                                        <form action="{{url('admin/proveedores',$proveedore->id)}}" method="post"
                                            onclick="preguntar{{$proveedore->id}}(event)" id="miformulario{{$proveedore->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                        <script>
                                            function preguntar{{$proveedore->id}}(event){
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
                                                        var form = $('#miformulario{{$proveedore->id}}');
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
            $('#example1').DataTable({
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ proveedores",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando proveedores del _START_ al _END_ de un total de _TOTAL_ proveedores",
                    "sInfoEmpty": "Mostrando proveedores del 0 al 0 de un total de 0 proveedores",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ proveedores)",
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