@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1><b>Listado de Arqueos</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Arqueos Registrados</h3>
                        <div class="card-tools">

                            <a href="{{url('admin/arqueos/reporte')}}" class="btn btn-danger" target="_blank"><i class="fa fa-file-pdf"></i>
                                Reporte
                            </a>
                            @if ($arqueoAbierto)

                            @else
                            <a href="{{url('admin/arqueos/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>
                                Registrar nuevo
                            </a>
                            @endif
                            
                        </div>
                </div>

                <div class="card-body">
                    <table id="example"class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th style="text-align: center">Nro</th>
                                <th>Fecha de Apertura</th>
                                <th>Monto Inicial</th>
                                <th>Fecha de Cierre</th>
                                <th>Monto Final</th>
                                <th>Descripción</th>
                                <th>Movimientos</th>
                                <th style="text-align: center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $contador =1; ?>
                        @foreach($arqueos as $arqueo)
                            <tr>
                                <td style="text-align: center">{{$contador++}}</td>
                            
                                <td>{{ \Carbon\Carbon::parse($arqueo->fecha_apertura)->format('Y-m-d H:i') }}</td>
                                <td>{{$arqueo->monto_inicial}}</td>
                                <td>{{ \Carbon\Carbon::parse($arqueo->fecha_)->format('Y-m-d H:i') }}</td>
                                <td>{{$arqueo->monto_final}}</td>
                                <td>{{$arqueo->descripcion}}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <b>Ingresos</b><br>
                                            {{$arqueo->total_ingresos}}
                                        </div>
                                    
                                        <div class="col-md-6">
                                            <b>Egresos</b><br>
                                            {{$arqueo->total_egresos}}

                                        </div>
                                    </div>
                                </td>

   
                                <td style="text-align: center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{url('admin/arqueos/'.$arqueo->id)}}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="{{url('admin/arqueos/'.$arqueo->id.'/edit')}}" class="btn btn-success"><i class="fas fa-pencil"></i></a>
                                        <a href="{{url('admin/arqueos/'.$arqueo->id.'/ingreso-egreso')}}" class="btn btn-warning"><i class="fas fa-cash-register"></i></a>
                                        <a href="{{url('admin/arqueos/'.$arqueo->id.'/cierre')}}" class="btn btn-secondary"><i class="fas fa-lock"></i></a>

                                       
                                        
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
                "sLengthMenu": "Mostrar _MENU_ Arqueos",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando Arqueos del _START_ al _END_ de un total de _TOTAL_ Arqueos",
                "sInfoEmpty": "Mostrando Arqueos del 0 al 0 de un total de 0 Arqueos",
                "sInfoFiltered": "(filtrado de un total de _MAX_ Arqueos)",
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