<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Detalle de Cuentas por Cobrar</title>
    <link rel="stylesheet" type="text/css" href="/public/style.css">
    <style>
        .table {
            width: 700px;
            height: auto;
        }
        th {
            background-color: gray;
            color: white;
        }
        table {
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="container">
     <div class="row">
        <div class="col-md-12">
            <h1 style="text-align:center;">Detalle de Cuentas por Cobrar </h1>
            <h3 style="text-align:center;">Licores y más Am. Pm.</h3>
            <h3 style="text-align:center;">Jalpatagua, Jutiapa </h3>
            <h4> Usuario: {{$user}}  </h4>
            <h4> Fecha de impresión: {{$today}} </h4>

            <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    @foreach ($total as $totales)
                    <td>Total de Cuentas por Cobrar:</td><td>Q.{{$totales->total}}</td>
                    @endforeach
                </tr>
            </table>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Empleado</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $dat)
                    <tr>
                        <td>{{ $dat->fecha }}</td>
                        <td>{{ $dat->nombrec }}</td>
                        <td>Q.{{ $dat->total_venta }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>