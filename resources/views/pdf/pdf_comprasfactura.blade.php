<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Detalle de Compras por Factura</title>
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
            <h1 style="text-align:center;">Detalle de Compras por Factura </h1>
            <h3 style="text-align:center;">Licores y más Am. Pm.</h3>
            <h3 style="text-align:center;">Jalpatagua, Jutiapa </h3>
            <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:15px;"> Usuario: {{$user}} </td>
                    <td style="font-size:15px;"> Fecha de Impresión: {{$today}} </td>
                </tr>
                <tr>
                    <td style="font-size:15px;"> Fecha de Inicio: {{$fecha_inicio}} </td>
                    <td style="font-size:15px;"> Fecha Final: {{$fecha_final}} </td>
                </tr>
            </table>
            <br>
            <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:20px;"> Total </td>
                    @foreach ($total as $total2)
                    <td style="font-size:20px;">Q. {{ $total2->Total }} </td>
                    @endforeach
                </tr>
            </table>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Serie</th>
                        <th>Num Factura</th>
                        <th>Proveedor</th>
                        <th>Total Factura</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $dat)
                    <tr>
                        <td>{{ $dat->fecha_factura }}</td>
                        <td>{{ $dat->serie_factura }}</td>
                        <td>{{ $dat->num_factura }}</td>
                        <td>{{ $dat->nombre_comercial }}</td>
                        <td>Q.{{ $dat->total }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>