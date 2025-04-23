@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1><b>Listado de Ventas</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Ventas Registradas</h3>
                        <div class="card-tools">
                            <a href="{{url('admin/ventas/reporte')}}" class="btn btn-danger" target="_blank"><i class="fa fa-file-pdf"></i>
                                Reporte
                            </a>
                            @if ($arqueoAbierto)
                                <a href="{{url('admin/ventas/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>
                                    Registrar nuevo
                                </a>
                        
                            @else
                                <a href="{{url('admin/arqueos/create')}}" class="btn btn-danger"><i class="fa fa-plus"></i>
                                    Abrir Caja
                                </a>
                            @endif
                            
                        </div>
                </div>

                <div class="card-body">
                    <table id="example1"class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th style="text-align: center">Nro</th>
                                <th>Fecha</th>
                                <th>Precio total</th>
                                <th>Productos</th>
                                <th style="text-align: center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $contador =1; ?>
                        @foreach($ventas as $venta)
                            <tr>
                                <td style="text-align: center">{{$contador++}}</td>
                                <td>{{$venta->fecha}}</td>
                                <td>{{$venta->precio_total}}</td>
                                <td>
                                    <ul>
                                        @foreach ($venta->detallesventa as $detalle)
                                            <li>{{$detalle->producto->nombre." - ".$detalle->cantidad." unidades"}}</li>
                                            
                                        @endforeach
                                    </ul>
                                </td>
                                
                                <td style="text-align: center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{url('admin/ventas/'.$venta->id)}}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="{{url('admin/ventas/'.$venta->id.'/edit')}}" class="btn btn-success"><i class="fas fa-pencil"></i></a>
                                        <a href="{{url('admin/ventas/pdf/'.$venta->id)}}" class="btn btn-warning" target="_blank"><i class="fas fa-print"></i></a>
                                        <form action="{{url('admin/ventas',$venta->id)}}" method="post"
                                            onclick="preguntar{{$venta->id}}(event)" id="miformulario{{$venta->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                        <script>
                                            function preguntar{{$venta->id}}(event){
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
                                                        var form = $('#miformulario{{$venta->id}}');
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
                    "sLengthMenu": "Mostrar _MENU_ ventas",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando ventas del _START_ al _END_ de un total de _TOTAL_ ventas",
                    "sInfoEmpty": "Mostrando ventas del 0 al 0 de un total de 0 ventas",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ ventas)",
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