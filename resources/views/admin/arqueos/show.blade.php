@extends('adminlte::page')

@section('content_header')
    <h1><b>Datos del Arqueo</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Datos Registrados</h3>
                    
            </div>

            <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fecha_apertura">Fecha Apertura</label> 
                                    <p>{{$arqueos->fecha_apertura}}</p>                                    

                                </div>
                            </div>
    
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="monto_inicial">Monto Inicial</label>
                                    <p>{{$arqueos->monto_inicial}}</p>                                    

                                </div>
                            </div>

                        
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fecha_cierre">Fecha Cierre</label> 
                                    <p>{{$arqueos->fecha_cierre}}</p>                                    

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="monto_final">Monto Final</label>
                                    <p>{{$arqueos->monto_final}}</p>                                    

                                </div>
                            </div>
                        

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <p>{{$arqueos->descripcion}}</p>                                    

                                </div>
                            </div>
                        </div> 
                    
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url('admin/arqueos')}}" class="btn btn-secondary">Volver</a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Ingresos Registrados</h3>  
            </div>

            <div class="card-body">
                <table class="table table-bordered table-sm table-striped table-hover">
                   <thead>
                    <tr>
                        <th style="text-align: center">Nro</th>
                        <th style="text-align: center">Detalle</th>
                        <th style="text-align: center">Monto</th>
                    </tr>
                   </thead>
                   <tbody>
                        <?php $contador =1; $suma = 0;?>
                        @foreach ($movimientos as $movimiento)
                            @if ($movimiento->tipo == "INGRESO")
                            @php
                                $suma += $movimiento->monto;
                            @endphp
                            <tr>
                                <td style="text-align: center">{{$contador++}}</td>
                                <th style="text-align: center">{{$movimiento->descripcion}}</th>
                                <th style="text-align: center">{{$movimiento->monto}}</th>
                            </tr>              
                            @endif
                        @endforeach
                        
                   </tbody>
                   <tfooter>
                    <tr>
                        <td style="text-align: right"colspan="2"><b>Total</b></td>
                        <td style="text-align: center" colspan="">{{$suma}}</td>
                    </tr>
                   </tfooter>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Egresos Registrados</h3>  
            </div>

            <div class="card-body">
                <table class="table table-bordered table-sm table-striped table-hover">
                    <thead>
                     <tr>
                         <th style="text-align: center">Nro</th>
                         <th style="text-align: center">Detalle</th>
                         <th style="text-align: center">Monto</th>
                     </tr>
                    </thead>
                    <tbody>
                         <?php $contador =1; $suma = 0;?>
                         @foreach ($movimientos as $movimiento)
                             @if ($movimiento->tipo == "EGRESO")
                             @php
                                 $suma += $movimiento->monto;
                             @endphp
                             <tr>
                                 <td style="text-align: center">{{$contador++}}</td>
                                 <th style="text-align: center">{{$movimiento->descripcion}}</th>
                                 <th style="text-align: center">{{$movimiento->monto}}</th>
                             </tr>              
                             @endif
                         @endforeach
                         
                    </tbody>
                    <tfooter>
                     <tr>
                         <td style="text-align: right"colspan="2"><b>Total</b></td>
                         <td style="text-align: center" colspan="">{{$suma}}</td>
                     </tr>
                    </tfooter>
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

@stop