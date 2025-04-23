@extends('adminlte::page')

@section('content_header')
    <h1><b>Detalle de la compra</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Datos Registrados</h3>
            </div>

            <div class="card-body">
                
                    <div class="row">
                        <div class="col-md-8">
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

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $cont =1; $total_cantidad = 0; $total_compra = 0?>
                                    @foreach($compras->detalles as $detalle)
                                        @php
                                        @endphp
                                        <tr>
                                            <td style="text-align: center">{{$cont++}}</td>
                                            <td style="text-align: center">{{$detalle->producto->codigo}}</td>
                                            <td style="text-align: center">{{$detalle->cantidad}}</td>
                                            <td style="text-align: center">{{$detalle->producto->nombre}}</td>
                                            <td style="text-align: center">{{$detalle->producto->precio_compra}}</td>
                                            <td style="text-align: center">{{$costo = $detalle->cantidad * $detalle->producto->precio_compra}}</td>
                                            
                                        </tr>
                                        @php
                                            $total_cantidad += $detalle->cantidad;
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
                                    

                                    <div class="col-md-12">
                                        <label for="">Proveedor</label>
                                        <input id="id_proveedor" type="text" value="{{$compras->proveedor->nombre}}" name="id_proveedor" class="form-control" disabled>                                 
                               
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha">Fecha de compra</label> 
                                        <input type="date" name="fecha" value="{{$compras->fecha}}" class="form-control" disabled>
                                        @error('fecha')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="comprobante">Comprobante</label> 
                                        <input type="text" name="comprobante" value="{{$compras->comprobante}}" class="form-control" disabled >
                                        @error('comprobante')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="precio_total">Precio total</label> <b>*</b>
                                        <input style="text-align: center" type="text" name="precio_total" value="{{$total_compra}}" class="form-control" disabled>
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
                                        
                                        <a href="{{url('/admin/compras')}}" class="btn btn-secondary btn-lg btn-block">Volver</a>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>

                    <hr>
                    
               
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
                $('#proveedor').val(proveedor);
                var id_proveedor = $(this).data('id');
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
        });
    </script>
@stop
