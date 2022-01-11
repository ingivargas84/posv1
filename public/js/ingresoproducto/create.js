$(document).ready(function() {

	$('#fecha_factura').datetimepicker({
		format: 'DD-MM-YYYY',
		showClear: true,
		showClose: true
	});

	$('#fecha_ingreso').datetimepicker({
		format: 'DD-MM-YYYY',
		showClear: true,
		showClose: true
	});


	$("#cantidad_ingreso").keypress(function(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode < 48 || charCode > 57)  return false;
		return true;
	});


	$.ajax({
		method: "GET",
		url: "/../venta/getProductos/",
		async: true,
		contentType: "application/json"
	}).done(function (data) {
		$("#producto_id").html("");
		$("#producto_id").selectpicker('refresh')
		$.each(data, function (id, data) {
			var opt = $('<option />');
			opt.val(data.id);
			opt.text(data.codigobarra + ' - ' + data.prod_nombre);
			$('#producto_id').append(opt);
		});
		$("#producto_id").selectpicker('refresh');
	}); 


$("#producto_id").change(function () {
		var codigo = $("#producto_id").val();
		/*var url = "../pos_v3/venta/get/?data=" + codigo;*/
		var url = "../venta/get/?data=" + codigo;
		$.getJSON( url , function ( result ) {
			if (result == 0 ) {
				$("input[name='descripcion'] ").val("");
			}
			else {
				$("input[name='descripcion'] ").val(result[0].prod_nombre);
			}
		});
	});


	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});

	var validator = $("#submit-ingresoproducto").validate({
		ignore: [],
		onkeyup:false,
		rules: {
			fecha_ingreso: {
				required : true
			},
			serie_factura : {
				required : true
			},
			num_factura : {
				required : true
			},
			fecha_factura : {
				required : true
			},
			proveedor_id : {
				required : true,
			}

		},
		messages: {
			fecha_ingreso : {
				required : "Por favor, seleccione la fecha de ingreso"
			},
			serie_factura : {
				required : "Por favor, ingrese la serie de la factura"
			},
			num_factura : {
				required : "Por favor, ingrese el numero de la factura"
			},
			fecha_factura : {
				required : "Por favor, seleccione la fecha de la factura"
			},
			proveedor_id : {
				required : "Por favor, seleccione al proveedor de la factura",
			}
		}
	});

});