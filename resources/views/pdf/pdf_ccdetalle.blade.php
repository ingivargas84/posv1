<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Detalle de Corte de Caja</title>
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
            <h1 style="text-align:center;">Detalle de Corte de Caja </h1>
            <h3 style="text-align:center;">Licores y más Am. Pm.</h3>
            <h3 style="text-align:center;">Jalpatagua, Jutiapa </h3>
            <h4> Usuario: {{$user}}  </h4>
            <h4> Fecha de impresión: {{$today}} </h4>

            <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                <tr>
                    @foreach ($efectivo1 as $efectivos)
                    <td>Ventas en Efectivo:</td><td>Q.{{$efectivos->efectivo}}</td>
                    @endforeach
                </tr>
                <tr>
                    @foreach ($tarjeta1 as $tarjetas)
                    <td>Ventas por Tarjeta:</td><td>Q.{{$tarjetas->tarjeta}}</td>
                    @endforeach
                </tr>
                <tr>
                    @foreach ($subtotal1 as $subtotales1)
                    <td>Total de Ventas del Día:</td><td>Q.{{$subtotales1->subtotal1}}</td>
                    @endforeach
                </tr>
            </table>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width=10%>Tipo de Venta</th>
                        <th width=20%>Codigo Barra</th>
                        <th width=30%>Producto</th>
                        <th width=10%>Existencias</th>
                        <th width=10%>Cantidad</th>
                        <th width=10%>Precio Venta</th>
                        <th width=10%>Venta Neta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $dat)
                    <tr>
                        <td>{{ $dat->Tipo_Venta }}</td>
                        <td>{{ $dat->Codigo_Barra }}</td>
                        <td>{{ $dat->Producto }}</td>
                        <td>{{ $dat->Existencias }}</td>
                        <td>{{ $dat->Cantidad_Vendida }}</td>
                        <td>Q.{{ $dat->Precio_Venta }}</td>
                        <td>Q.{{ $dat->Venta }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>