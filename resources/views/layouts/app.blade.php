<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>POS Licores y más</title>

	<link rel="stylesheet" href="{{ URL::to("css/font-awesome.min.css")  }}">
	<link rel="stylesheet" href="{{ URL::to("css/css.css")  }}">
	<link rel="stylesheet" href="{{ URL::to("css/all.css")  }}">
	<link rel="stylesheet" href="{{ URL::to("css/bootstrap-select.min.css")  }}">
	<link rel="stylesheet" href="{{ URL::to("css/bootstrap-datetimepicker.min.css")  }}">
	<link rel="stylesheet" href="{{ URL::to("css/bootstrap.min.css")  }}">
	<link rel="stylesheet" href="{{ URL::to("css/buttons.dataTables.min.css")  }}">
	<link rel="stylesheet" href="{{ URL::to("css/bootstrap-toggle.min.css")  }}">
	<link rel="stylesheet" href="{{ URL::to('css/style.css') }}">
	<link rel="stylesheet" href="{{ URL::to("css/dataTables.bootstrap.min.css")  }}">
	<link rel="stylesheet" href="{{ URL::to("css/responsive.bootstrap.min.css")  }}">
	<link rel="stylesheet" href="{{asset('css/morris.css') }}">
	

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('font-awesome-4.5.0/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('fontawesome/css/fontawesome.min.css') }}">
  <link rel="stylesheet" href="{{asset('fontawesome/css/all.css') }}">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/ladda-themeless.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/ladda.min.css">
	<link rel="stylesheet" href="{{ URL::to("css/admin.min.css")  }}">

	<script src="{{ URL::to("js/jquery.min.js")  }}"></script>
	<script src="{{ URL::to("js/bootstrap.min.js")  }}"></script>
	<script src="{{ URL::to("js/jquery.validate.js")  }}"></script>
	<script src="{{ URL::to("js/moment.min.js")  }}"></script>
	<script src="{{ URL::to("js/bootstrap-select.min.js")  }}"></script>
	<script src="{{ URL::to("js/bootstrap-datetimepicker.min.js")  }}"></script>
	<script src="{{asset('js/morris.min.js') }}"></script>
	<script src="{{asset('js/raphael-min.js') }}"></script>


	{{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
	<style>
		body {
			font-family: 'Lato';
		}

		.fa-btn {
			margin-right: 6px;
		}
	</style>
</head>
<body id="app-layout">
	<nav class="navbar navbar-default navbar-static-top" style="background-color: #3094d6;">
		<div class="container">
			<div class="navbar-header">
				<!-- Collapsed Hamburger -->
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<!-- Branding Image -->
				<a class="navbar-brand" style="
				color: white;" href="{{ url('/home') }}">
				Licores y más Am. Pm.
			</a>
		</div>

		<div class="collapse navbar-collapse" id="app-navbar-collapse">
			<!-- Left Side Of Navbar -->
			<ul class="nav navbar-nav">
				<li><a href="{{ url('/home') }}">Inicio</a></li>

				@if (Auth::guest())
				<!-- <li><a href="{{ url('/login') }}">Ingresar</a></li> -->
				<!-- <li><a href="{{ url('/register') }}">Register</a></li> -->
				@else


				@if ( Auth::user()->is("consulta|administrator|superadmin|cajero"))
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						Operación <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						@if ( Auth::user()->is("consulta|administrator|cajero|superadmin") )
						<li><a href="{{ url('/ventas') }}"><i class="fa fa-btn fa-sign-out"></i>Ventas</a></li>
						@endif
						<!-- @if ( Auth::user()->is("consulta|administrator|cajero|superadmin") )
						<li><a href="{{ url('/construccion') }}"><i class="fa fa-btn fa-sign-out"></i>Facturación</a></li>
						@endif -->
						@if ( Auth::user()->is("consulta|administrator|superadmin"))
						<li><a href="{{ url('/ingresoproducto') }}"><i class="fa fa-btn fa-sign-out"></i>Ingreso de Productos (Compras)</a></li>
						@endif
						<!-- @if ( Auth::user()->is("consulta|administrator|superadmin"))
						<li><a href="{{ url('/salidaproducto') }}"><i class="fa fa-btn fa-sign-out"></i>Salida de Productos </a></li>
						@endif -->
						<!-- @if ( Auth::user()->is("consulta|administrator|cajero|superadmin") )
						<li><a href="{{ url('/cuentaxcobrar') }}"><i class="fa fa-btn fa-sign-out"></i>Cuentas por Cobrar (Créditos) </a></li>
						@endif -->
						@if ( Auth::user()->is("consulta|superadmin"))
						<li><a href="{{ url('/partidamaestro') }}"><i class="fa fa-btn fa-sign-out"></i>Partida de Ajuste</a></li>
						@endif
					</ul>
				</li>
				@endif


				@if ( Auth::user()->is("administrator|cajero|superadmin|consulta"))
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						Catálogos <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						@if ( Auth::user()->is("superadmin|administrator|consulta"))
						<li><a href="{{ url('/proveedor') }}"><i class="fa fa-btn fa-sign-out"></i>Proveedores</a></li>
						@endif
						@if ( Auth::user()->is("superadmin|administrator|consulta"))
						<li><a href="{{ url('/producto') }}"><i class="fa fa-btn fa-sign-out"></i>Productos</a></li>
						@endif
						<!-- @if ( Auth::user()->is("superadmin|administrator|consulta"))
						<li><a href="{{ url('/cliente') }}"><i class="fa fa-btn fa-sign-out"></i>Clientes</a></li>
						@endif -->
						<!-- @if ( Auth::user()->is("superadmin|consulta"))
						<li><a href="{{ url('/construccion') }}"><i class="fa fa-btn fa-sign-out"></i>Administrar Facturas</a></li>
						@endif -->
					</ul>
				</li>
				@endif

				@if ( Auth::user()->is("superadmin|cajero|administrator|consulta"))
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						Acciones <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						@if ( Auth::user()->is("superadmin|cajero|administrator|consulta"))
						<li><a  id="cortecaja"><i class="fa fa-btn fa-sign-out"></i>Ejecutar Corte de Caja</a></li>
						@endif
						<!-- @if ( Auth::user()->is("superadmin|consulta"))
						<li><a href="{{ url('/construccion') }}"><i class="fa fa-btn fa-sign-out"></i>Asignar Método de Inventario</a></li>
						@endif -->
					</ul>
				</li>
				@endif

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						Reportes <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						@if ( Auth::user()->is("consulta|superadmin|cajero|administrator"))
						<li><a href="{{ url('/pdf_ccdetalle') }}" target="_blank"><i class="fa fa-btn fa-sign-out"></i>Corte de Caja - Detalle</a></li>
						@endif
						@if ( Auth::user()->is("consulta|superadmin|cajero|administrator"))
						<li><a href="{{ url('/pdf_ccresumen') }}" target="_blank"><i class="fa fa-btn fa-sign-out"></i>Corte de Caja - Resumen</a></li>
						@endif
						@if ( Auth::user()->is("superadmin|administrator|cajero|consulta"))
						<li><a href="{{ url('/rpt_existenciaprod') }}"><i class="fa fa-btn fa-sign-out"></i>Existencias de Productos</a></li>
						@endif
						@if ( Auth::user()->is("consulta|superadmin"))
						<li><a href="{{ url('/rpt_existencia') }}"><i class="fa fa-btn fa-sign-out"></i>Inventario General de Productos y Costos</a></li>
						@endif
						@if ( Auth::user()->is("superadmin|consulta"))
						<li><a href="{{ url('/rpt_ganancia') }}"><i class="fa fa-btn fa-sign-out"></i>Ganancias por Fechas</a></li>
						@endif
						@if ( Auth::user()->is("consulta|superadmin"))
						<li><a href="{{ url('/rpt_ventasuf') }}"><i class="fa fa-btn fa-sign-out"></i>Ventas por Fechas y Usuario</a></li>
						@endif
						@if ( Auth::user()->is("consulta|administrator|superadmin"))
						<li><a href="{{ url('/rpt_ingreso') }}"><i class="fa fa-btn fa-sign-out"></i>Ingresos de Productos por Fechas</a></li>
						@endif
						<!-- @if ( Auth::user()->is("consulta|administrator|superadmin"))
						<li><a href="{{ url('/rpt_salida') }}"><i class="fa fa-btn fa-sign-out"></i>Salidas de Productos por Fechas</a></li>
						@endif -->
						<!-- @if ( Auth::user()->is("consulta|administrator|superadmin"))
						<li><a href="{{ url('/rpt_comprasfactura') }}"><i class="fa fa-btn fa-sign-out"></i>Compras por Factura - Resumen</a></li>
						@endif -->
						@if ( Auth::user()->is("consulta|administrator|superadmin"))
						<li><a href="{{ url('/rpt_comprasfactura') }}"><i class="fa fa-btn fa-sign-out"></i>Compras por Factura - Detalle</a></li>
						@endif
						<!-- @if ( Auth::user()->is("consulta|administrator|superadmin"))
						<li><a href="{{ url('/rpt_comprasfactura') }}"><i class="fa fa-btn fa-sign-out"></i>Cuentas por Cobrar por Cliente y Fecha - Resumen</a></li>
						@endif -->
						<!-- @if ( Auth::user()->is("consulta|administrator|superadmin"))
						<li><a href="{{ url('/rpt_comprasfactura') }}"><i class="fa fa-btn fa-sign-out"></i>Cuentas por Cobrar por Cliente y Fecha - Detalle</a></li>
						@endif -->
						<!-- @if ( Auth::user()->is("consulta|administrator|superadmin"))
						<li><a href="{{ url('/rpt_comprasfactura') }}"><i class="fa fa-btn fa-sign-out"></i>Facturas Emitidas por Fecha - Resumen</a></li>
						@endif -->
						<!-- @if ( Auth::user()->is("consulta|administrator|superadmin"))
						<li><a href="{{ url('/rpt_comprasfactura') }}"><i class="fa fa-btn fa-sign-out"></i>Facturas Emitidas por Fecha - Detalle</a></li>
						@endif -->
						@if ( Auth::user()->is("consulta|superadmin"))
						<li><a href="{{ url('/ajuste') }}"><i class="fa fa-btn fa-sign-out"></i>Partida de Ajuste del Mes</a></li>
						@endif
					</ul>
				</li>
				@endif

			</ul>
			<!-- Right Side Of Navbar -->
			<ul class="nav navbar-nav navbar-right">
				<!-- Authentication Links -->
				
				@if (Auth::guest())
				<li><a href="{{ url('/login') }}">Ingresar</a></li>
				<!-- <li><a href="{{ url('/register') }}">Register</a></li> -->
				@else
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						{{ Auth::user()->name }} <span class="caret"></span>
					</a>

					<ul class="dropdown-menu" role="menu">
						<li><a class="edit-my-user" href="#"><i class="fa fa-btn fa-user"></i>Cambiar Contraseña</a></li>
						@if ( Auth::user()->is("superadmin|consulta"))
						<li><a href="{{ url('/user') }}"><i class="fa fa-btn fa-sign-out"></i>Administrar Usuarios</a></li>
						@endif
						<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Cerrar Sesión (Salir)</a></li>
					</ul>
				</li>
				@endif
			</ul>
		</div>
	</div>
</nav>



@if ( !Auth::guest())
@include("users.edit-my-account")
@include("users.edit-my-user")
@include("users.delete-modal")
@include("users.delete-special")

@endif
<div class="container">
	<div class="row">
		<div class="col-md-12">
			@yield('content')
		</div>
	</div>
</div>
<div class="footer">
	<p><h6 class="text-center">Creado por VR Informática & Sistemas - Todos los derechos reservados - VR-POS, Versión 3.1 - 2021</h6></p>
</div>


<!--    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> -->
<script src="{{ URL::to("js/users/update.js")  }}"></script>
<script src="{{ URL::to("js/users/update-information.js")  }}"></script>
<script src="{{ URL::to("js/datatable/initialize.js")  }}"></script>
<script src="{{ URL::to("js/datatable/custom_render.js")  }}"></script>
<script src="{{ URL::to("js/datatable/jquery.dataTables.min.js")  }}"></script>
<script src="{{ URL::to("js/datatable/dataTables.bootstrap.min.js")  }}"></script>
<script src="{{ URL::to("js/datatable/dataTables.responsive.min.js")  }}"></script>
<script src="{{ URL::to("js/datatable/responsive.bootstrap.min.js")  }}"></script>{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
{!! HTML::script('/js/jsgrid.min.js') !!}
{!! HTML::style('/css/jsgrid.css') !!}
{!! HTML::style('/css/theme.css') !!}

<!-- <script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js"></script> -->
<!-- <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script> -->
<!-- <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script> -->
<!-- <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> -->

<script src="{{ URL::to("js/dataTables.buttons.min.js")  }}"></script>
<script src="{{ URL::to("js/buttons.html5.min.js")  }}"></script>
<script src="{{ URL::to("js/pdfmake.min.js")  }}"></script>
<script src="{{ URL::to("js/vfs_fonts.js")  }}"></script>
<script src="{{ URL::to("js/jszip.min.js")  }}"></script>
<script src="{{ URL::to("js/bootstrap-toggle.min.js")  }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/spin.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/ladda.jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/ladda.min.js"> </script>

<script>

document.onkeydown = function(e) {
    if (e.ctrlKey && (e.keyCode === 74)) {//ctrl+u Alt+c, Alt+v will also be disabled sadly.
      e.preventDefault();
    }
    else {
      return true;
    }
  };

	$('body').on('click', '#cortecaja', function(e) {
		$( ".confirm-delete" , "#userDeleteModal").removeAttr("field");
		var id = $(this).parent().parent().attr("id");
		unsetPasswordErrors("password_delete2");
		$("input[name='password_delete2']").val("");
		$("#userDeleteModal2").hide().show();
		$("#userDeleteModal2").modal();

	});

	function unsetPasswordErrors( input_name )
	{
		$("#password_delete-error2").addClass("hidden");
		$("#password_delete-error2").text( "" );
	}

	function setPassworddErrors( input_name , text )
	{
		$("#password_delete-error2").removeClass("hidden");
		$("#password_delete-error2").text( text );
	}

	$('body').on('click', 'button.confirm-delete2', function( e ) {
		e.preventDefault();
		var url = "/cortecaja";
		var password_delete = $("input[name='password_delete2']").val().trim();
		data = {
			password_delete : password_delete
		};

		$("#user-created-message").addClass("hidden");

		$.ajax({
			method: "POST",
			url: url,
			data: JSON.stringify(data),
			contentType: "application/json",
		}).done(function (data){
			$("#userDeleteModal2").modal("hide");
			alert('El corte de caja se ha realizado exitosamente!!');
		}).fail(function(errors) {
			var errors = JSON.parse(errors.responseText);
			if (errors.password_delete != null) setPassworddErrors("password_delete2", errors.password_delete);
			else unsetPasswordErrors("password_delete2");
		});
	});
</script>
@yield('scripts')

</body>
</html>