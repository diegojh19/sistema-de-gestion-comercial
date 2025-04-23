@extends('adminlte::page')

@section('content_header')
    <h1><b>Editar venta</b></h1>
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
                <form action="{{(url('/admin/ventas',$ventas->id))}}" id="form_venta" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="cantidad">Cantidad</label> <b>*</b>
                                        <input type="number"  id="cantidad" value="1" class="form-control" required name="cantidad">
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
                                        <input id="codigo" type="text"  value="{{old('codigo')}}" class="form-control" >
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
                                        @foreach($ventas->detallesventa as $detalle)
                                        
                                        <tr>
                                            <td style="text-align: center">{{$cont++}}</td>
                                            <td style="text-align: center">{{$detalle->producto->codigo}}</td>
                                            <td style="text-align: center">{{$detalle->cantidad}}</td>
                                            <td style="text-align: center">{{$detalle->producto->nombre}}</td>
                                            <td style="text-align: center">{{$detalle->producto->precio_venta}}</td>
                                            <td style="text-align: center">{{$costo = $detalle->cantidad * $detalle->producto->precio_compra}}</td>
                                            <td style="text-align: center">
                                                <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{$detalle->id}}"><i class="fa fa-trash"></i></button>
                                            </td>
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
                                    <div class="col-md-6">
                                        <!-- Botón para abrir el modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalproveedor"><i class="fas fa-search"></i>Buscar Cliente</button>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal_crear_cliente"><i class="fas fa-plus"></i></button>
                                    </div>  
                                </div>
                                <hr>
                                <div class="row">
                                    
                                    <input id="id_cli" type="text" name="id_cliente" class="form-control" value="{{$ventas->cliente->id ?? ''}}" hidden>                                 
                               
                                    <div class="col-md-6">
                                        <label for="">Nombre del cliente</label>
                                        <input id="nom_cliente" type="text" name="" class="form-control" value="{{$ventas->cliente->nombre_cliente ?? 'S/N' }}">  
                               
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Nit del cliente</label>
                                        <input id="nit_cliente" type="text" name="" class="form-control" value="{{$ventas->cliente->nit_codigo ?? '0'}}">  
                               
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="fecha">Fecha de venta</label> <b>*</b>
                                        <input type="date" name="fecha" value="{{old('fecha',$ventas->fecha)}}" class="form-control" >
                                        @error('fecha')
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
                                        
                                        <button type="submit" class="btn btn-success btn-lg btn-block"><i class="fas fa-save"></i> Actualizar venta</button>
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
<div class="modal fade" id="exampleModal_crear_cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar Nuevo Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre_cliente">Nombre del Cliente</label>
                                    <input type="text" name="nombre_cliente" id="nombre_cliente" value="{{old('nombre_cliente')}}" class="form-control" required>
                                    @error('nombre_cliente')
                                        <small class="text-danger" style="color::red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nit_codigo">Nit/Código del Cliente</label>
                                    <input type="text" name="nit_codigo" id="nit_codigo" value="{{old('nit_codigo')}}" class="form-control" required>
                                    @error('nit_codigo')
                                        <small class="text-danger" style="color::red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" name="telefono" id="telefono" value="{{old('telefono')}}" class="form-control" required>
                                @error('telefono')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" value="{{old('email')}}" class="form-control" required>
                                @error('email')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                @enderror
                            </div>
                        </div>

                        
                    </div>
                    <hr>
                    
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" onclick="guardar_cliente()" class="btn btn-primary"><i class="fas fa-save"></i> Registrar</button>

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
                <h5 class="modal-title" id="exampleModalLabel">Listado de Clientes</h5>
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
                            <th>Nombre del cliente</th>
                            <th>Nit/Código</th>
                            <th>Teléfono</th>
                            <th>Email</th>

                        </tr>
                    </thead>

                    <tbody>
                        <?php $contador =1; ?>
                    @foreach($clientes as $cliente)
                        <tr>
                            <td style="text-align: center">{{$contador++}}</td>
                            <td>
                                <button type="button" class="btn btn-info seleccionarcliente-btn" data-id="{{$cliente->id}}" data-nit="{{$cliente->nit_codigo}}" data-nombre="{{$cliente->nombre_cliente}}">Seleccionar</button>
                            </td>
                            <td>{{$cliente->nombre_cliente}}</td>
                            <td>{{$cliente->nit_codigo}}</td>
                            <td>{{$cliente->telefono}}</td>
                            <td>{{$cliente->email}}</td>

 
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

        function guardar_cliente(){
            //alert("hola")
            const data = { // recuperar los datos
                nombre_cliente: $('#nombre_cliente').val(),
                nit_codigo: $('#nit_codigo').val(),
                telefono: $('#telefono').val(),
                email: $('#email').val(),
                _token: '{{csrf_token()}}'
            };

            $.ajax({

                url: "{{route('admin.ventas.clientes.store')}}",
                type: 'POST',
                data: data,
                success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: "Se agrego al cliente",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                location.reload();
                            } else {
                                alert('Error no se pudo registrar el cliente');
                            }
                        },
                        error: function (error) {
                            alert(error);
                        }
          
            });
        }


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

            // Manejo del botón de selección de cliente
            $('.seleccionarcliente-btn').click(function () {

                var nom_cliente = $(this).data('nombre');
                $('#nom_cliente').val(nom_cliente);

                var id_cli = $(this).data('id');
                $('#id_cli').val(id_cli);

                var nit_codigo = $(this).data('nit');
                $('#nit_cliente').val(nit_codigo);

                $('#exampleModalproveedor').modal('hide');
                $('#exampleModalproveedor').on('hidden.bs.modal', function (){
                   
                });

            });

            // Manejo del botón de eliminar
            $('.delete-btn').click(function () {
                var id = $(this).data('id');
                if (id) {
                    $.ajax({
                        url: "{{url('/admin/ventas/detalle')}}/"+id,
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
            $('#form_venta').on('keydown', function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                }
            });

            // Evento cuando el código del producto es ingresado
            $('#codigo').on('keyup', function (e) {
                if (e.which === 13) {
                    var codigo = $(this).val();
                    var cantidad = $('#cantidad').val();
                    var id_venta = '{{$ventas->id}}';
                    if (codigo.length > 0) {
                        $.ajax({
                            url: "{{route('admin.detalle.ventas.store')}}",
                            method: 'POST',
                            data: {
                                _token: '{{csrf_token()}}',
                                codigo: codigo,
                                cantidad: cantidad,
                                id_venta: id_venta
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
                                    alert(response.message);                         

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
                        "sLengthMenu": "Mostrar _MENU_ clientes",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando clientes del _START_ al _END_ de un total de _TOTAL_ clientes",
                        "sInfoEmpty": "Mostrando clientes del 0 al 0 de un total de 0 clientes",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ clientes)",
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
