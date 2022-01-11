<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Example 2</title>
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
            <h1 style="text-align:center;">Reporte Existencias por Productos </h1>
            <h3 style="text-align:center;">Licores y más Am. Pm.</h3>
            <h3 style="text-align:center;">Jalpatagua, Jutiapa </h3>
            <h4> Usuario: {{$user}}  </h4>
            <h4> Fecha de impresión: {{$today}} </h4>
            <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    <td style="font-size:20px;"> Total de Inventario </td>
                    @foreach ($total as $totales)
                    <td style="font-size:20px;">Q. {{ $totales->Total }} </td>
                    @endforeach
                </tr>
            </table>
            <br>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Existencias</th>
                        <th>Precio Costo</th>
                        <th>Total Neto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $dts)
                    <tr>
                        <td>{{ $dts->codigobarra }}</td>
                        <td>{{ $dts->Producto }}</td>
                        <td>{{ $dts->Existencias }}</td>
                        <td>Q.{{ $dts->Precio_Costo }}</td>
                        <td>Q.{{ $dts->Subtotal }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>