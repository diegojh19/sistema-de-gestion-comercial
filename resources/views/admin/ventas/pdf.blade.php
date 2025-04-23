<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
       body {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12pt;
    color: #333;
}

.table {
    width: 100%;
    margin-bottom: 1rem;
    color: #212529;
    border-collapse: collapse;
}

.table-bordered {
    border: 1px solid #000;
}

.table-bordered th,
.table-bordered td {
    border: 1px solid #000;
}

.table-bordered thead th {
    border-bottom-width: 2px;
}


    </style>
    <title>sistema de venta</title>
  </head>
  <body>
    <table border="0" >
        <thead>
            <tr>
                <td><img src="{{public_path('storage/'.$empresa->logo)}}" width="200px" alt=""></td>
                <td width="250"></td>
                <td style="text-align: center">
                    <b>Nit:</b> {{$empresa->nit}} <br>
                    <b>Nro Factura:</b> {{$ventas->id}}
                </td>

            </tr>
            <tr>
                <td style="text-align: center">
                    {{$empresa->nombre_empresa}} <br>
                    {{$empresa->tipo_empresa}} <br>
                    {{$empresa->correo}} <br>
                    Tel: {{$empresa->telefono}}
                </td>

                <td width="250px" style="text-align: center"><h2>FACTURA</h2></td>
                <td style="text-align: center"><b>Original</b></td>
            </tr>
        </thead>
    </table>

    <br>

    

    <div style="border: 1px solid #000000">
        <table border="0" cellpadding="6">
            <th>
                <tr>
                    <td><b>Fecha:</b> {{ $fechaFormateada }}</td>
                    <td width="300px"></td>
                    <td><b>Nit/CI</b>{{$ventas->cliente->nit_codigo ?? ''}}</td>
                </tr>
    
                <tr>
                    <td><b>Señor(es):</b> {{$ventas->cliente->nombre_cliente ?? ''}}</td>
                </tr>
            </th>
        </table>
    </div>

    <br>

    <table class="table table-bordered">
        <thead style="background-color: #cccccc">
            <tr>
                <td width="30px" style="text-align: center"><b>Nro</b></td>
                <td width="140px" style="text-align: center"><b>Productos</b></td>
                <td width="180px" style="text-align: center"><b>Descripción</b></td>
                <td width="70" style="text-align: center"><b>Cantidad</b></td>
                <td width="90" style="text-align: center"><b>Precio Unitario</b></td>
                <td width="90" style="text-align: center"><b>SubTotal</b></td>
            </tr>
        </thead>

        <tbody>
            <?php $contador =1; $subtotal = 0; $sumacantidad = 0; $sumapreciounitario = 0; $sumatotal = 0; ?>
                @foreach($ventas->detallesventa as $detalle)
                    @php
                        $subtotal = $detalle->cantidad * $detalle->producto->precio_venta;
                        $sumacantidad += $detalle->cantidad;
                        $sumapreciounitario += $detalle->producto->precio_venta; 
                        $sumatotal += $subtotal;
                    @endphp
                    <tr>
                        <td style="text-align: center">{{$contador++}}</td>
                        <td>{{$detalle->producto->nombre}}</td>
                        <td>{{$detalle->producto->descripcion}}</td>
                        <td style="text-align: center">{{$detalle->cantidad}}</td>
                        <td style="text-align: center">{{$moneda->symbol." ".$detalle->producto->precio_venta}}</td>
                        <td style="text-align: center">{{$moneda->symbol." ".$subtotal}}</td>
                    </tr>
                @endforeach

                <tr style="background-color: #cccccc">
                    <td colspan="3" style="text-align:center"><b>Total</b></td>
                    <td style="text-align:center"><b>{{$sumacantidad}}</b></td>
                    <td style="text-align:center"><b>{{$moneda->symbol." ".$sumapreciounitario}}</b></td>
                    <td style="text-align:center"><b>{{$moneda->symbol." ".$sumatotal}}</b></td>

                </tr>
            
        </tbody>
    </table>

    <p>
        <b>monto a cancelar: </b> {{$ventas->precio_total}} <br>
        <b>son: {{$literal}} </b>
    </p>

    <p style="text-align: center">
        -------------------------------------------------------------------------------------------------------------------
        <br><b>GRACIAS POR SU PREFERENCIA</b>
    </p>

  </body>
</html>