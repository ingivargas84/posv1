$(document).on("keypress", 'form', function (e) {
	var code = e.keyCode || e.which;
	if (code == 13) {
		e.preventDefault();
		return false;
	}
});

$(document).on("keypress", '#addPartidaDetalle', function (e) {
	var code = e.keyCode || e.which;
	if (code == 13) {
		e.preventDefault();
		return false;
	}
});

$(document).on("keypress", '#ButtonPartidaDetalle', function (e) {
	var code = e.keyCode || e.which;
	if (code == 13) {
		e.preventDefault();
		return false;
	}
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
	var mov = $("#tipo_ajuste_id").val();
	var url = "/../venta/getpartida/?data=" + codigo + "&mov=" + mov;
	$.getJSON( url , function ( result ) {
		if (result == 0 ) {
			$("input[name='descripcion'] ").val("");
			$("input[name='precio_costo'] ").val("");
			$("input[name='cantidad_ajuste'] ").val(1);
			$("#total_existencia").text("El producto no existe");
		}   
		else {
			$("input[name='descripcion'] ").val(result[0].prod_nombre);
			$("input[name='precio_costo'] ").val(result[0].precio_compra);
			$("input[name='existencias'] ").val(result[0].existencias);
			$("input[name='cantidad_ajuste'] ").val(1);
			$("input[name='movimiento_id'] ").val(result[0].producto_id);
			$("#total_existencia").text("La existencia del producto con el precio Q." + result[0].precio_venta + " es de:" + result[0].existencias);
		}
	});
});


$("input[name='cantidad_ajuste']").focusout(function() {
	var cantidad_ajuste = $("input[name='cantidad_ajuste'] ").val();
	var precio_costo = $("input[name='precio_costo'] ").val();


	var subtotal = cantidad_ajuste * precio_costo;
	if (cantidad_ajuste != 0 ) {
		$("input[name='subtotal'] ").val(subtotal);
	}
	else 
		$("input[name='subtotal'] ").val("0");
	return false;
})


$("input[name='precio_costo']").focusout(function() {
	var cantidad = $("input[name='cantidad_ajuste'] ").val();
	var precio_costo = $("input[name='precio_costo'] ").val();

	var subtotal = cantidad * precio_costo;
	if (cantidad != 0 ) {
		$("input[name='subtotal'] ").val(subtotal);
	}
	else 
		$("input[name='subtotal'] ").val("0");
	return false;
})


$('body').on('click', '#addPartidaDetalle', function(e) 
{
	var l = Ladda.create( document.querySelector( '#addPartidaDetalle' ) );
	l.start();
	l.setProgress( 0.5 );
	if($("input[name='partida_maestro']").val() == "") 
	{
		var total = $("input[name='subtotal'] ").val();
		var tipo_ajuste_id = $("#tipo_ajuste_id").val();
		var formData = {total: total, tipo_ajuste_id : tipo_ajuste_id} 
		$.ajax({
			type: "GET",
			url: "/pdetalle/save/",
			data: formData,
			async:false,
			dataType: "json",
			success: function(data) {
				var detalle = data;
				$("input[name='partida_maestro'] ").val(data.id);
			},
			error: function() {
				alert("Error, no se pudo generar el detalle de la partida");
			}
		});
	}

	if (parseInt($("#tipo_ajuste_id").val()) == 1) {
		var detalle = new Object();
		var cantidad_ajuste = $("input[name='cantidad_ajuste'] ").val();
		var precio_costo = $("input[name='precio_costo'] ").val();
		var subtotal = cantidad_ajuste * precio_costo;
		var producto_id = $("#producto_id").val();

		if (parseInt($("#tipo_ajuste_id").val()) == 1)
		{
			var ingreso = $("input[name='subtotal'] ").val();
			var salida = 0;
		}
		else{
			var ingreso = 0;
			var salida = $("input[name='subtotal'] ").val();
		}

		detalle.cantidad_ajuste = $("input[name='cantidad_ajuste'] ").val();
		detalle.precio_costo = $("input[name='precio_costo'] ").val();
		detalle.producto_id  = $("#producto_id").val();
		detalle.prod_nombre = $("input[name='descripcion'] ").val();
		detalle.movimiento_id  = $("input[name='movimiento_id'] ").val();
		detalle.ingreso = ingreso;
		detalle.salida = salida;

		var total_ingreso = $("input[name='total_ingreso'] ").val();
		if (total_ingreso != 0){
			var total_ingreso = parseFloat(total_ingreso) + parseFloat(ingreso);
			var total_ingreso_f = $("input[name='total_ingreso'] ").val(total_ingreso);
		}else {
			var total_ingreso = parseFloat(ingreso);
			var total_ingreso_f = $("input[name='total_ingreso'] ").val(total_ingreso);  
		}  

		var total_salida = $("input[name='total_salida'] ").val();
		if (total_salida != 0) {
			var total_salida = parseFloat(total_salida) + parseFloat(salida);
			var total_salida_f = $("input[name='total_salida'] ").val(total_salida);
		} else {
			var total_salida = parseFloat(salida);
			var total_salida_f = $("input[name='total_salida'] ").val(total_salida);
		}

		var diferencia = $("input[name='diferencia'] ").val();
		var diferencia = parseFloat(total_ingreso) - parseFloat(total_salida);
		var total_diferencia_f = $("input[name='diferencia'] ").val(diferencia);

		dbs.detalles.push(detalle);
		$("#producto_id").val("");
		$("input[name='codigobarra'] ").val("");
		$("input[name='descripcion'] ").val("");
		$("input[name='precio_costo'] ").val("");
		$("input[name='subtotal'] ").val("");
		$("input[name='cantidad_ajuste'] ").val(1);
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


		var cantidad_ajuste = $("input[name='cantidad_ajuste'] ").val();
		var precio_costo = $("input[name='precio_costo'] ").val();
		var subtotal = cantidad_ajuste * precio_costo;
		$("input[name='subtotal'] ").val(subtotal);
		var partida_maestro = $("input[name='partida_maestro'] ").val();
		if($("input[name='partida_maestro']").val() != "") {       
			$.ajax({
				url: "/partida-detalle/" + partida_maestro,
				type: "POST",
				contentType: "application/json",
				data: JSON.stringify(dbs.detalles),
				success: function(addressResponse) {
					detalle.partida_detalle = addressResponse.id
					db.links.push(detalle);
					$("#partidadetalle-grid .jsgrid-search-button").trigger("click");
					dbs.detalles = "";
					window.dbs = dbs;
					dbs.detalles = [];
				},
				always: function() {
				}
			});
		}
	}
	else {
		if (parseInt($("input[name='existencias'] ").val()) >= parseInt($("input[name='cantidad_ajuste'] ").val()))
		{
			if ($("input[name='descripcion'] ").val() != "" && $("input[name='cantidad'] ").val() != "") {
				var detalle = new Object();
				var cantidad_ajuste = $("input[name='cantidad_ajuste'] ").val();
				var precio_costo = $("input[name='precio_costo'] ").val();
				var subtotal = cantidad_ajuste * precio_costo;
				var producto_id = $("#producto_id").val();
				
				if (parseInt($("#tipo_ajuste_id").val()) == 1)
				{
					var ingreso = $("input[name='subtotal'] ").val();
					var salida = 0;
				}
				else{
					var ingreso = 0;
					var salida = $("input[name='subtotal'] ").val();
				}

				detalle.cantidad_ajuste = $("input[name='cantidad_ajuste'] ").val();
				detalle.precio_costo = $("input[name='precio_costo'] ").val();
				detalle.producto_id  = producto_id;
				detalle.prod_nombre = $("input[name='descripcion'] ").val();
				detalle.movimiento_id  = $("input[name='movimiento_id'] ").val();
				detalle.ingreso = ingreso;
				detalle.salida = salida;

				var total_ingreso = $("input[name='total_ingreso'] ").val();
				if (total_ingreso != 0){
					var total_ingreso = parseFloat(total_ingreso) + parseFloat(ingreso);
					var total_ingreso_f = $("input[name='total_ingreso'] ").val(total_ingreso);
				}else {
					var total_ingreso = parseFloat(ingreso);
					var total_ingreso_f = $("input[name='total_ingreso'] ").val(total_ingreso);  
				}  

				var total_salida = $("input[name='total_salida'] ").val();
				if (total_salida != 0) {
					var total_salida = parseFloat(total_salida) + parseFloat(salida);
					var total_salida_f = $("input[name='total_salida'] ").val(total_salida);
				} else {
					var total_salida = parseFloat(salida);
					var total_salida_f = $("input[name='total_salida'] ").val(total_salida);
				}

				var diferencia = $("input[name='diferencia'] ").val();
				var diferencia = parseFloat(total_ingreso) - parseFloat(total_salida);
				var total_diferencia_f = $("input[name='diferencia'] ").val(diferencia);

				dbs.detalles.push(detalle);
				$("#producto_id").val("");
				$("input[name='codigobarra'] ").val("");
				$("input[name='descripcion'] ").val("");
				$("input[name='precio_costo'] ").val("");
				$("input[name='subtotal'] ").val("");
				$("input[name='cantidad_ajuste'] ").val(1);
				var cantidad_ajuste = $("input[name='cantidad_ajuste'] ").val();
				var precio_costo = $("input[name='precio_costo'] ").val();
				var subtotal = cantidad_ajuste * precio_costo;
				$("input[name='subtotal'] ").val(subtotal);
				var partida_maestro = $("input[name='partida_maestro'] ").val();
				if($("input[name='partida_maestro']").val() != "") {       
					$.ajax({
						url: "/partida-detalle/" + partida_maestro,
						type: "POST",
						contentType: "application/json",
						data: JSON.stringify(dbs.detalles),
						success: function(addressResponse) {
							detalle.partida_detalle = addressResponse.id
							db.links.push(detalle);
							$("#partidadetalle-grid .jsgrid-search-button").trigger("click");
							dbs.detalles = "";
							window.dbs = dbs;
							dbs.detalles = [];
						},
						always: function() {
						}
					});
				}
				$("#partidadetalle-grid .jsgrid-search-button").trigger("click");
			}
			else {
				alert("Especifique un producto valido o cantidad");
			}
		}
		else {
			alert("No se puede realizar el registro, revise las existencias del producto");
		}
	}
	l.stop();
});


(function() {

	var db = {

		loadData: function(filter) {
			return $.grep(this.links, function(link) {
				return (!filter.name || link.name.indexOf(filter.name) > -1)
				&& (!filter.url || link.url.indexOf(filter.url) > -1);
			});
		},

		insertItem: function(insertingLink) {
			this.links.push(insertingLink);
			console.log(insertingLink);
		},

		updateItem: function(updatingLink) {
			console.log(updatingLink);
		},

		deleteItem: function(deletingLink) {
			$.ajax({
				type: "DELETE",
				url: "/partidadetalle2/destroy/"+ deletingLink.partida_detalle+ "/" + deletingLink.movimiento_id,
				data: deletingLink,
				dataType: "json",
				success: function(data) {
					var detalle = data;
				},
				error: function() {
					alert("Error, no se ha podido realizar la eliminación");
				}
			});


			var linkIndex = $.inArray(deletingLink, this.links);
			if (deletingLink.salida != 0) {
				var total_salida = $("input[name='total_salida'] ").val();
				var new_total = parseFloat(total_salida) - parseFloat(deletingLink.salida);
				var total_final = $("input[name='total_salida'] ").val(new_total); 
				var diferencia = $("input[name='diferencia'] ").val();
				var new_diferencia = parseFloat(diferencia) + parseFloat(deletingLink.salida);
				var total_diferencia = diferencia = $("input[name='diferencia'] ").val(new_diferencia);
			}

			if (deletingLink.ingreso != 0) {
				var total_ingreso = $("input[name='total_ingreso'] ").val();
				var new_total = parseFloat(total_ingreso) - parseFloat(deletingLink.ingreso);
				var total_final = $("input[name='total_ingreso'] ").val(new_total); 
				var diferencia = $("input[name='diferencia'] ").val();
				var new_diferencia = parseFloat(diferencia) - parseFloat(deletingLink.ingreso);
				var total_diferencia = diferencia = $("input[name='diferencia'] ").val(new_diferencia);
			}
			this.links.splice(linkIndex, 1);
		}

	};

	var dbs = {

		loadData: function(filter) {
			return $.grep(this.links, function(link) {
				return (!filter.name || link.name.indexOf(filter.name) > -1)
				&& (!filter.url || link.url.indexOf(filter.url) > -1);
			});
		},

		insertItem: function(insertingLink) {
			this.detalles.push(insertingLink);
			console.log(insertingLink);
		},

		updateItem: function(updatingLink) {
			console.log(updatingLink);
		},

		deleteItem: function(deletingLink) {
			var linkIndex = $.inArray(deletingLink, this.links);
			this.detalles.splice(linkIndex, 1);
		}

	};
	window.db = db;
	window.dbs = dbs;
	db.links = [];
	dbs.detalles = [];


	function saveDetalle(button) {
		var total_ingreso = $("input[name='total_ingreso'] ").val();
		var total_salida  = $("input[name='total_salida']").val();
		var saldo = $("input[name='diferencia'] ").val();
		var partida_maestro = $("input[name='partida_maestro'] ").val();
		var formData = 
		{total_ingreso: total_ingreso, total_salida : total_salida, saldo: saldo} 
		$.ajax({
			type: "PATCH",
			url: "/partida/update-total/"+ partida_maestro + "/",
			data: formData,
			dataType: "json",
			success: function(data) {
				var detalle = data;	
				window.location = "/partidamaestro"
			},
			error: function() {
				alert("Something went wrong, please try again!");
			}
		});
	}

	$("#ButtonPartidaDetalle").click(function(event) {
		saveDetalle();
	});


	$(document).ready(function () {

		$("#partidadetalle-grid").jsGrid({
			width: "",
			filtering: false,
			editing: false,
			sorting: true,
			paging: true,
			autoload: true,
			inserting: false,
			pageSize: 20,
			pagerFormat: "Pages: {prev} {pages} {next} | {pageIndex} of {pageCount} |",
			pageNextText: '>',
			pagePrevText: '<',
			deleteConfirm: "Esta seguro de borrar el producto",
			controller: db,
			fields: [
				// { title: "Id", name: "id", type:"number", index:"id", filtering:false, editing:false, inserting:false},
				{ title: "Producto", name: "prod_nombre", type: "text"},
				{ title: "C贸digo", name: "producto_id", type: "text", visible:false},
				{ title: "partida_maestro_id", name: "partida_maestro_id", type: "text", visible:false},
				{ title: "Cantidad", name: "cantidad_ajuste", type: "text"},
				{ title: "Precio Costo", name: "precio_costo", type: "text"},
				{ title: "Ingreso", name: "ingreso", type: "text"},
				{ title: "Salida", name: "salida", type: "text"},
				{ type: "control" }
				],
				onItemInserting: function (args) {
				},
				onItemUpdating: function (object) {
				},
				onRefreshed : function () {
					$('tbody').children('.jsgrid-insert-row').children('td').children('input').first().focus();
				}
			});
	});
}());