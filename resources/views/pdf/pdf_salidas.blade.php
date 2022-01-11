<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte de Salida</title>
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
<body><div class="container">
 <div class="row">
    <div class="col-md-12">
        <h1 style="text-align:center;">Reporte de Salida de Productos </h1>
        <h3 style="text-align:center;">Licores y más Am. Pm.</h3>
            <h3 style="text-align:center;">Jalpatagua, Jutiapa </h3>
        
        <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
            <tr>
                <td style="font-size:15px;"> Usuario: {{$user}}  </td>
                <td style="font-size:15px;"> Fecha de impresión: {{$today}} </td>
            </tr>
            <tr>
                <td style="font-size:15px;"> Fecha de Inicio: {{$fecha_inicio}}  </td>
                <td style="font-size:15px;"> Fecha Final: {{$fecha_final}} </td>
            </tr>
        </table>
        <br>
        <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
            <tr>
                <td style="font-size:20px;"> Total </td>
                @foreach ($total as $totales)
                <td style="font-size:20px;">Q. {{ $totales->Total_Neto }} </td>
                @endforeach
            </tr>
        </table>
        <br>
        <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width=15%>Fecha</th>
                    <th width=15%>Código</th>
                    <th width=25%>Producto</th>
                    <th width=20%>Tipo Salida</th>
                    <th width=10%>Cantidad</th>
                    <th width=15%>Total Neto</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $dat)
                <tr>
                    <td>{{ $dat->Fecha_Salida }}</td>
                    <td>{{ $dat->Codigo }}</td>
                    <td>{{ $dat->Producto }}</td>
                    <td>{{ $dat->Tipo_Salida }}</td>
                    <td>{{ $dat->Cantidad }}</td>
                    <td>Q{{ $dat->Total_Neto }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
</body>
</html>