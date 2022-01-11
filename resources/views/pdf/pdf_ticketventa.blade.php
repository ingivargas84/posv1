<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Ticket</title>
	<style>
		.table {
			width: 150px;
			height: auto;
		}
		table {
			border-collapse: collapse;
		}
		table, th, td {
			border: 0px solid white;
			margin:0px;
			padding:0px;
		}

		body {
			font-size: 10px;
			margin:0px;
			padding:0px;
		}

		@page { margin: 5px; }


	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div id="page-wrapper">
					<div id="page-inner">
						<div class="row" style="text-align: center;">
                        <div class="col-sm-4">
                            <table  class="table">
								<tr> <td> <h3 style="text-align: center;">Licores y más </h3> </td> </tr>
								<tr> <td> <h4 style="text-align: center;">Barrio en Gozo, camino al hospital</h4> </td> </tr>
								<tr> <td><h4 style="text-align: center;">Jalpatagua, Jutiapa </h4> </td> </tr>
								<tr> <td><h4 style="text-align: center;"> <strong>Vendedor:</strong> {{$vendedor[0]->name}} </h4> </td> </tr>
						</table>

                        </div>
						</div>
						<hr>
						<div class="row" style="text-align: center;">
							<div class="col-sm-12">
								<table  class="table">
									<thead >
										<tr>
											<th width=10>Cant</th>
											<th width=70>Producto</th>
											<th width=0.000001%>Total</th>
										</tr>
									</thead>
									
									<tbody>
										@foreach ($ventadetalle as $detalle)
										<tr>
											<td>
												{{$detalle->cantidad}}
											</td>
											<td>
												{{App\Producto::find($detalle->producto_id)->prod_nombre}}
											</td>
											<td>
												Q.{{{ number_format((float) $detalle->subtotal, 2) }}}
											</td>
										</tr>
									@endforeach
							</tbody>
						</table>
                        <hr>
					</div>
					<div class="row">
                    <div class="col-sm-4">
                            <table  class="table">
								<tr><td><h3 style="text-align: center;">Total: Q.{{{ number_format((float) $ventamaestro[0]->total_venta, 2) }}} </h3>	</td></tr>
								<tr><td><h3 style="text-align: center;">Whatsapp: 3149-3323 </h3>	</td></tr>
								<tr><td><h3 style="text-align: center;">{{{Carbon\Carbon::parse($ventamaestro[0]->created_at)->format('d-m-Y H:m:s')}}} horas </h3>	</td></tr>
						</table>

                        </div>
					</div>
					
			</div>
		</div>
	</div>
</div>
</body>
</html>