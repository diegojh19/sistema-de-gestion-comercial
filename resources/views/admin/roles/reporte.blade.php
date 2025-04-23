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
            margin: 0;
        }

        .header{
            
            background-color: #f0f0f0;
            
        }

        .footer{

            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30px;
            background-color: #f0f0f0;
            text-align: center;
            line-height: 30px;
            font-size: 12px;
            border-top: 1px solid #ddd;

        }

        .content{
            margin: 10px 20px 50px 20px;
        }
        .page-number:before{
            content: "Página" counter(page);

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
  </head>
  <body>
    <div class="header">
        <table border="0" >
            <thead>
                <tr>
                    
                </tr>
                <tr>
                    <td style="text-align: center">
                        {{$empresa->nombre_empresa}} <br>
                        {{$empresa->tipo_empresa}} <br>
                        {{$empresa->correo}} <br>
                        Tel: {{$empresa->telefono}}
                    </td>
    
                    <td width="615px" style="text-align: center"><h2>SISTEMA DE VENTAS</h2></td>
                    <td> <img src="{{public_path('storage/'.$empresa->logo)}}" width="200px" alt=""></td>
                </tr>
            </thead>
        </table>
    </div>
   
    <div class="content">
        
        <h2>Reporte de roles</h2>

        <table class="table table-bordered" cellpadding="5">
            <thead style="background-color: #cccccc">
                <tr>
                    <td width="30px" style="text-align: center"><b>Nro</b></td>
                    <td width="140px" style="text-align: center"><b>Roles</b></td>
                    <td width="180px" style="text-align: center"><b>Fecha y Hora de registro</b></td>
                    
                </tr>
            </thead>
    
            <tbody>
                <?php $contador =1; $subtotal = 0; $sumacantidad = 0; $sumapreciounitario = 0; $sumatotal = 0; ?>
                    @foreach($roles as $rol)
                        
                        <tr>
                            <td style="text-align: center">{{$contador++}}</td>
                            <td>{{$rol->name}}</td>
                            <td>{{$rol->created_at}}</td>

                            
                        </tr>
                    @endforeach
                
            </tbody>
        </table>

    </div>

    <div class="footer">
        <small class="page-number"></small>

    </div>

  </body>
</html>