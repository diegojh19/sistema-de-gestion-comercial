@extends('adminlte::page')

@section('content_header')
    <h1><b>Detalle de la venta</b></h1>
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
                                    @foreach($ventas->detallesventa as $detalle)
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
                                    
                                <input id="id_cli" type="text" name="id_cliente" class="form-control" hidden>                                 
                           
                                <div class="col-md-6">
                                    <label for="">Nombre del cliente</label>
                                    <input id="nom_cliente" type="text" value="{{$ventas->cliente->nombre_cliente ?? 'S/N'}}" class="form-control" value="S/N" disabled>  
                           
                                </div>

                                <div class="col-md-6">
                                    <label for="">Nit del cliente</label>
                                    <input id="nit_cliente" type="text" name="" class="form-control" value="{{$ventas->cliente->nit_codigo ?? '0'}}" disabled>  
                           
                                </div>
                            </div>
                        <hr>
                                <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="fecha">Fecha de venta</label> 
                                        <input type="date" name="fecha" value="{{$ventas->fecha}}" class="form-control" disabled>
                                        @error('fecha')
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
                                        
                                        <a href="{{url('/admin/ventas')}}" class="btn btn-secondary btn-lg btn-block">Volver</a>
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
 
@stop
