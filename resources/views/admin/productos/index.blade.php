@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1><b>Listado de Productos</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Productos Registrados</h3>
                        <div class="card-tools">
                            <a href="{{url('admin/productos/reporte')}}" class="btn btn-danger" target="_blank"><i class="fa fa-file-pdf"></i>
                                Reporte
                            </a>
                            <a href="{{url('admin/productos/create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>
                                Registrar nuevo
                            </a>
                        </div>
                </div>

                <div class="card-body">
                    <table id="example1"class="table table-striped table-bordered table-hover table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th style="text-align: center">Nro</th>
                                <th>Categoria</th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Stock</th>
                                <th>Stock Minimo</th>
                                <th>Precio compra</th>
                                <th>Precio venta</th>
                                <th>Imagen</th>
                                <th style="text-align: center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $contador =1; ?>
                        @foreach($productos as $producto)
                            <tr>
                                <td style="text-align: center">{{$contador++}}</td>
                                <td>{{$producto->categoria->name}}</td>
                                <td>{{$producto->codigo}}</td>
                                <td>{{$producto->nombre}}</td>
                                <td>{{$producto->descripcion}}</td>
                                <td>{{$producto->stock}}</td>
                                <td>
                                    @if($producto->stock <= $producto->stock_minimo)
                                        <span class="badge bg-warning text-dark">Stock mínimo alcanzado</span><br>
                                        {{$producto->stock_minimo}}
                                    @else
                                        <span class="badge bg-success">Stock suficiente</span><br>
                                        {{$producto->stock}}

                                    @endif
                                </td>
                                <td>{{$producto->precio_compra}}</td>
                                <td>{{$producto->precio_venta}}</td>
                                <td>
                                    <img src="{{asset('storage/'.$producto->imagen)}}" width="50px" height="50px" alt="imagen">
                                </td>


   
                                <td style="text-align: center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{url('admin/productos/'.$producto->id)}}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="{{url('admin/productos/'.$producto->id.'/edit')}}" class="btn btn-success"><i class="fas fa-pencil"></i></a>
                                        <form action="{{url('admin/productos',$producto->id)}}" method="post"
                                            onclick="preguntar{{$producto->id}}(event)" id="miformulario{{$producto->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                        <script>
                                            function preguntar{{$producto->id}}(event){
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
                                                        var form = $('#miformulario{{$producto->id}}');
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
                    "sLengthMenu": "Mostrar _MENU_ productos",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando productos del _START_ al _END_ de un total de _TOTAL_ productos",
                    "sInfoEmpty": "Mostrando productos del 0 al 0 de un total de 0 productos",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ productos)",
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