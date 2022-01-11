<!DOCTYPE html>
<html lang="en">
<head><meta charset="big5">
    
    <title>Resumen de Corte de Caja</title>
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
            <h1 style="text-align:center;">Resumen de Corte de Caja </h1>
            <h3 style="text-align:center;">Licores y más Am. Pm.</h3>
            <h3 style="text-align:center;">Jalpatagua, Jutiapa </h3>
            <h4> Usuario: {{$user}}  </h4>
            <h4> Fecha de impresión: {{$today}} </h4>
            <br><br>
        </div>
        <div>
        <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
            <tr>
                @foreach ($efectivo as $efectivos)
                <td>(1) - (+) Ventas en Efectivo:</td><td>Q.{{$efectivos->efectivo}}</td>
                @endforeach
            </tr>
            <tr>
                @foreach ($tarjeta as $tarjetas)
                <td>(2) - (+) Ventas por Tarjeta:</td><td>Q.{{$tarjetas->tarjeta}}</td>
                @endforeach
            </tr>
            <tr>
                <td>(3) - (+) Caja Chica:</td><td>Q. 250.00</td>
            </tr>
            <tr>
                @foreach ($subtotal11 as $subtotales11)
                <td>(4)=(1+2+3) - Subtotal Ventas y Caja Chica:</td><td>Q.{{$subtotales11->subtotal11}}</td>
                @endforeach
            </tr>
            <tr>
                @foreach ($tarjeta as $tarjetas)
                <td>(5) - (-) Ventas por Tarjeta:</td><td>Q.{{$tarjetas->tarjeta}}</td>
                @endforeach
            </tr>
            <tr>
                @foreach ($subtotal12 as $subtotales12)
                <td>(6)=(4-5) - Subtotal en Caja:</td><td>Q.{{$subtotales12->subtotal12}}</td>
                @endforeach
            </tr>
            <tr>
                <td>(7) - (-) Acreditación de Caja Chica:</td><td>Q. 250.00</td>
            </tr>
            <tr>
                @foreach ($efectivo as $efectivos)
                <td>(8)=(6-7) - Subtotal de Ventas en Efectivo:</td><td>Q.{{$efectivos->efectivo}}</td>
                @endforeach
            </tr>
            <tr>
                <td>(9) - (-) Compras en Efectivo:</td><td>_____________________________</td>
            </tr>
            <tr>
                <td>(10) - (-) Gastos en Efectivo:</td><td>_____________________________</td>
            </tr>
            <tr>
                <td>(11)=(8-(9+10)) - Total a Depositar / Entregar:</td><td>_____________________________</td>
            </tr>
            </table>
            </div>
<br><br>
<h4> Firma de Responsable:_____________________________ </h4>
<h4> Nombre del Responsable:_____________________________ </h4>
<br><br><br>
<h4 style="text-align:right"> Firma de Administrador/Auditor:_____________________________ </h4>
<h4 style="text-align:right"> Nombre de Administrador/Auditor:_____________________________ </h4>

<div>



            </div>
        </body>
        </html>