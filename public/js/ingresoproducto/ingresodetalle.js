function unsetPasswordErrors( input_name )
{
	$("#"+input_name+"-error").addClass("hidden");
	$("#"+input_name+"-error").text( "" );
	$("#"+input_name+"-error").parent().parent().removeClass("has-error");
}

function setPassworddErrors( input_name , text )
{
	$("#"+input_name+"-error").removeClass("hidden");
	$("#"+input_name+"-error").text( text );
	$("#"+input_name+"-error").parent().parent().addClass("has-error");
}


$('body').on('click', 'a.remove-ingresodetalle', function(e) {
	$( ".confirm-delete" , "#userDeleteModal").removeAttr("field");
	var id = $(this).parent().parent().attr("id");
	$("input[name='password_delete']").val("");
	unsetPasswordErrors("password_delete");
	var user = $(this).parent().parent().parent().parent().children().eq(0).text();
	$("#userDeleteModal").hide().show();
	$("#userDeleteModal").modal();
	if (user.length = 1) {
		$("#message").text("este ingreso?");
		$(".variable").text("");
		$(".entity").text("");
	} else {
		$("#message").text("esta ingreso");
		$(".variable").text("");
		$(".entity").text("");
	}
	$(".confirm-delete", "#userDeleteModal").attr("id", "delete-" + id);
});


$('body').on('click', 'a.edit-ingresodetalle', function(e) {
	e.preventDefault();
	unsetFieldErrors("existencias");
	$("#ingresodetalleUpdateModal").modal();
	$("#ingresodetalleUpdateModal").hide().show();
	$("#password-changed").addClass("hidden");
	var id = $(this).parent().parent().attr("id");
	/*var url= "/pos_v3/ingresodetalle/name/"+id;*/
	var url= "ingresodetalle/name/"+id;
	$.getJSON( url , function ( data ) {
		$('#edit-ingresoproducto-form').data("id", id);
		$("#edit-ingresoproducto-form input[name='existencias']").val( data.existencias);
		$("#edit-ingresoproducto-form input[name='precio_compra']").val( data.precio_compra);
		$("#edit-ingresoproducto-form input[name='precio_venta']").val( data.precio_venta);
	});
	$('#fecha_factura').datetimepicker({
		format: 'DD-MM-YYYY',
		showClear: true,
		showClose: true
	});

});

function unsetFieldErrors( input_name )
{
	$("#"+input_name+"-error").addClass("hidden");
	$("#"+input_name+"-error").text( "" );
	$("#"+input_name+"-error").parent().parent().removeClass("has-error");
}

function setFieldErrors( input_name , text )
{
	$("#"+input_name+"-error").removeClass("hidden");
	$("#"+input_name+"-error").text( text );
	$("#"+input_name+"-error").parent().parent().addClass("has-error");
}

$('body').on('click', 'button.confirm-delete', function( e ) {
	e.preventDefault();
	var id  = $(this).attr("id").replace("delete-", "");

	var td  = $("#"+id);

	/*var url = "/pos_v3/ingresodetalle/destroy/"+id;*/
	var url = "/ingresodetalle/destroy/"+id;
	var password_delete = $("input[name='password_delete']").val().trim();
	data = {
		password_delete : password_delete
	};

	$("#user-created-message").addClass("hidden");

	$.ajax({
		method: "DELETE",
		url: url,
		data: JSON.stringify(data),
		contentType: "application/json",
	}).done(function (data){
		$(".user-created-message").removeClass("hidden");
		$(".user-created-message").addClass("alert-success");
		$(".user-created-message").fadeIn();
		$(".user-created-message > p").text("Ingreso borrado exitosamente!");
		venta_detalle.ajax.reload();
		$("#userDeleteModal").modal("hide");
	}).fail(function(errors) {
		var errors = JSON.parse(errors.responseText);
		if (errors.password_delete != null) setPassworddErrors("password_delete", errors.password_delete);
		else unsetPasswordErrors("password_delete");
	});
	return false;
});