@extends('adminlte::page')

@section('content_header')
    <h1><b>Registro de una nueva compra</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Complete los campos</h3>
            </div>

            <div class="card-body">
                <form action="{{(url('/admin/compras/create'))}}" id="form_compra" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="cantidad">Cantidad</label> <b>*</b>
                                        <input type="number" name="cantidad" id="cantidad" value="1" class="form-control" required>
                                        @error('cantidad')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="codigo">Código</label> <b>*</b>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fas fa-barcode"></i></span>
                                        </div>
                                        <input id="codigo" type="text" name="codigo" value="{{old('codigo')}}" class="form-control" >
                                        @error('codigo')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div style="height: 32px"></div>
                                        <!-- Botón para abrir el modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-search"></i></button>
                                        <a  href="{{url('admin/productos/create')}}" class="btn btn-success"><i class="fas fa-plus"></i></a>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <table class="table table-sm table-striped table-bordered table-hover">
                                    <thead>
                                        <tr style="background-color: #cccccc">
                                            <th style="text-align: center">Nro</th>
                                            <th style="text-align: center">Código</th>
                                            <th style="text-align: center">Cantidad</th>
                                            <th style="text-align: center">Nombre</th>
                                            <th style="text-align: center">Costo</th>
                                            <th style="text-align: center">Total</th>
                                            <th style="text-align: center">Acción</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $cont =1; $total_cantidad = 0; $total_compra = 0?>
                                    @foreach($tmp_compras as $tmp_compra)
                                        @php
                                        @endphp
                                        <tr>
                                            <td style="text-align: center">{{$cont++}}</td>
                                            <td style="text-align: center">{{$tmp_compra->producto->codigo}}</td>
                                            <td style="text-align: center">{{$tmp_compra->cantidad}}</td>
                                            <td style="text-align: center">{{$tmp_compra->producto->nombre}}</td>
                                            <td style="text-align: center">{{$tmp_compra->producto->precio_compra}}</td>
                                            <td style="text-align: center">{{$costo = $tmp_compra->cantidad * $tmp_compra->producto->precio_compra}}</td>
                                            <td style="text-align: center">
                                                <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{$tmp_compra->id}}"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @php
                                            $total_cantidad += $tmp_compra->cantidad;
                                            $total_compra += $costo;
                                        @endphp
                                    @endforeach
                                        
                                    </tbody>
                                    <tfooter>
                                        <tr>
                                            <td colspan="2" style="text-align: right"><b>Total cantidad</b></td>
                                            <td style="text-align:center"><b>{{$total_cantidad}}</b></td>
                                            <td colspan="2" style="text-align: right"><b>Total compra</b></td>
                                            <td style="text-align:center"><b>{{$total_compra}}</b></td>
                                        </tr>
                                    </tfooter>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Botón para abrir el modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalproveedor"><i class="fas fa-search"></i>Buscar Proveedor</button>
                                    </div>

                                    <div class="col-md-6">
                                        
                                        <input id="proveedor" type="text" name="" class="form-control" disabled>  
                                        <input id="id_proveedor" type="text" name="id_proveedor" class="form-control" hidden>                                 
                               
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha">Fecha de compra</label> <b>*</b>
                                        <input type="date" name="fecha" value="{{old('fecha')}}" class="form-control" >
                                        @error('fecha')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="comprobante">Comprobante</label> <b>*</b>
                                        <input type="text" name="comprobante" value="{{old('comprobante')}}" class="form-control" >
                                        @error('comprobante')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="precio_total">Precio total</label> <b>*</b>
                                        <input style="text-align: center" type="text" name="precio_total" value="{{$total_compra}}" class="form-control" >
                                        @error('precio_total')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                
                                
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        
                                        <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fas fa-save"></i> Registrar compra</button>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>

                    <hr>
                    
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Listado de Productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="example1"class="table table-striped table-bordered table-hover table-sm table-responsive">
                    <thead class="thead-light">
                        <tr>
                            <th style="text-align: center">Nro</th>
                            <th>Acción</th>
                            <th>Categoria</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Stock</th>
                            <th>Stock Minimo</th>
                            <th>Precio compra</th>
                            <th>Precio venta</th>
                            <th>Imagen</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $contador =1; ?>
                    @foreach($productos as $producto)
                        <tr>
                            <td style="text-align: center">{{$contador++}}</td>
                            <td>
                                <button type="button" class="btn btn-info seleccionar-btn" data-id="{{$producto->codigo}}">Seleccionar</button>
                            </td>
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
                                <img src="{{asset('storage/'.$producto->imagen)}}" width="80px" alt="imagen">
                            </td>
 
                        </tr>
                    @endforeach
                        
                    </tbody>
                    
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalproveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Listado de Proveedores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="example11"class="table table-striped table-bordered table-hover table-sm table-responsive">
                    <thead class="thead-light">
                        <tr>
                            <th style="text-align: center">Nro</th>
                            <th>Acción</th>
                            <th>Empresa</th>
                            <th>Teléfono</th>
                            <th>Nombre del provedor</th>
                            
                        </tr>
                    </thead>

                    <tbody>
                        <?php $contador =1; ?>
                    @foreach($proveedores as $proveedore)
                        <tr>
                            <td style="text-align: center">{{$contador++}}</td>
                            <td>
                                <button type="button" class="btn btn-info seleccionarproveedor-btn" data-id="{{$proveedore->id}}" data-nombre="{{$proveedore->nombre}}">Seleccionar</button>
                            </td>
                            <td>{{$proveedore->empresa}}</td>
                            <td>{{$proveedore->telefono}}</td>
                            <td>{{$proveedore->nombre}}</td>
                           
 
                        </tr>
                    @endforeach
                        
                    </tbody>
                    
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>

@stop

@section('js')
     <!-- JS necesario para AdminLTE -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
 
 
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
 
     
     <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
     <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
 
    <script>
        $(document).ready(function () {
            // Eliminar el fondo (backdrop) cuando el modal se cierre
            $('#exampleModal').on('hidden.bs.modal', function () {
                // Eliminar el backdrop manualmente
                $('.modal-backdrop').remove();
                $(this).removeData('bs.modal'); // Limpia los datos del modal
                console.log('Modal cerrado y fondo eliminado');
            });

            $('#exampleModalproveedor').on('hidden.bs.modal', function () {
                // Eliminar el backdrop manualmente
                $('.modal-backdrop').remove();
                $(this).removeData('bs.modal'); // Limpia los datos del modal
                console.log('Modal cerrado y fondo eliminado');
            });

            // Manejo del botón de selección de producto
            $('.seleccionar-btn').click(function () {
                var id_producto = $(this).data('id');
                $('#codigo').val(id_producto);
                $('#exampleModal').modal('hide');
                $('#exampleModal').on('hidden.bs.modal', function (){
                    $('#codigo').focus();
                });

            });

            // Manejo del botón de selección de proveedor
            $('.seleccionarproveedor-btn').click(function () {
                var proveedor = $(this).data('nombre');
                
                var id_proveedor = $(this).data('id');
                $('#proveedor').val(proveedor);
                $('#id_proveedor').val(id_proveedor);
                $('#exampleModalproveedor').modal('hide');
                $('#exampleModalproveedor').on('hidden.bs.modal', function (){
                   
                });

            });

            // Manejo del botón de eliminar
            $('.delete-btn').click(function () {
                var id = $(this).data('id');
                if (id) {
                    $.ajax({
                        url: "{{url('/admin/compras/create/tmp')}}/" + id,
                        type: 'POST',
                        data: {
                            _token: '{{csrf_token()}}',
                            _method: 'DELETE'
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: "Se eliminó el producto",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                location.reload();
                            } else {
                                alert('Error no se pudo eliminar el producto');
                            }
                        },
                        error: function (error) {
                            alert(error);
                        }
                    });
                }
            });
            $('#codigo').focus();

            // Prevent form submission with Enter key
            $('#form_compra').on('keydown', function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                }
            });

            // Evento cuando el código del producto es ingresado
            $('#codigo').on('keyup', function (e) {
                if (e.which === 13) {
                    var codigo = $(this).val();
                    var cantidad = $('#cantidad').val();
                    if (codigo.length > 0) {
                        $.ajax({
                            url: "{{route('admin.compras.tmp_compras')}}",
                            method: 'POST',
                            data: {
                                _token: '{{csrf_token()}}',
                                codigo: codigo,
                                cantidad: cantidad
                            },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "success",
                                        title: "El Registro Producto",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    location.reload();
                                } else {
                                    alert('No se encontró el producto');
                                }
                            },
                            error: function (error) {
                                alert(error);
                            }
                        });
                    }
                }
            });

            // Inicializa DataTable cuando el modal se abre
            $('#exampleModal').on('shown.bs.modal', function () {
                if ($.fn.dataTable.isDataTable('#example1')) {
                    $('#example1').DataTable().destroy();
                }

                $('#example1').DataTable({
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ productos",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando productos del _START_ al _END_ de un total de _TOTAL_ productos",
                        "sInfoEmpty": "Mostrando productos del 0 al 0 de un total de 0 productos",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ productos)",
                        "sSearch": "Buscar:",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sPrevious": "Anterior",
                            "sNext": "Siguiente",
                            "sLast": "Último"
                        }
                    },
                    "pageLength": 10
                });
            });

            $('#exampleModalproveedor').on('shown.bs.modal', function () {
                if ($.fn.dataTable.isDataTable('#example11')) {
                    $('#example11').DataTable().destroy();
                }

                $('#example11').DataTable({
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ proveedores",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando proveedores del _START_ al _END_ de un total de _TOTAL_ proveedores",
                        "sInfoEmpty": "Mostrando proveedores del 0 al 0 de un total de 0 proveedores",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ proveedores)",
                        "sSearch": "Buscar:",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sPrevious": "Anterior",
                            "sNext": "Siguiente",
                            "sLast": "Último"
                        }
                    },
                    "pageLength": 10
                });
            });
        });
    </script>
@stop
