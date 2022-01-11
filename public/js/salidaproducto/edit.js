$('body').on('click', 'a.edit-salidaproducto', function(e) {
	e.preventDefault();
	$("#salidaproductoUpdateModal").modal();
	$("#salidaproductoUpdateModal").hide().show();
	$("#password-changed").addClass("hidden");
	var id = $(this).parent().parent().attr("id");
	/*var url= "/pos_v3/tiposalida/"+id;*/
	var url= "tiposalida/"+id;
	$.getJSON( url , function ( data ) {
		$('#edit-salidaproducto-form').data("id", id);
		var tipo_salida_id = data.tipo_salida_id;
		$('#tipo_salida_id option').each(function(option) {
			if (this.value == tipo_salida_id) {
				$(this).parent().val( this.value );
				return false;
			}
		});
	});
});


$("#cantidad_salida").keypress(function(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode < 48 || charCode > 57)  return false;
	return true;
});


$("#edit-salidaproducto-form").submit(function(e) {
	e.preventDefault();
	var id = $(this).data("id");
	/*var url = "pos_v3/salidaproducto/" + id + "/update";*/
	var url = "salidaproducto/" + id + "/update";
	var tipo_salida_id = $("#edit-salidaproducto-form #tipo_salida_id").val();
	data = {
		tipo_salida_id: tipo_salida_id,
	};
	$(".user-created-message").addClass("hidden");
	$.ajax({
		method: "PATCH",
		url: url,
		data: JSON.stringify(data),
		contentType: "application/json",
	}).done(function(data) {
		$(".user-created-message").removeClass("hidden");
		$(".user-created-message").addClass("alert-success");
		$(".user-created-message").fadeIn();
		$(".user-created-message > p").text("Salida de Producto editada exitosamente!");
		$('#salidaproductoUpdateModal').modal("hide");
		salidaproducto_table.ajax.reload();
	}).fail(function(errors) {
		var errors = JSON.parse(errors.responseText);
		if (errors.cantidad_salida != null) setFieldErrors("cantidad_salida", errors.cantidad_salida);
		else unsetFieldErrors("cantidad_salida");
	});
	return false;
});


$('#password-changed').on('close.bs.alert', function ( e ) {
	e.preventDefault();
	$(this).fadeOut();
	return false;
});

$('#fecha_salida').datetimepicker({
	format: 'DD-MM-YYYY',
	showClear: true,
	showClose: true
});

$("#closePassword").click( function(e){
	e.preventDefault();
	unsetPasswordErrors( "new-password");
	unsetPasswordErrors( "old-password");
	unsetPasswordErrors( "old-verify");
	$("input[name='new-password']").val("");
	$("input[name='old-password']").val("");
	$("input[name='old-verify']").val("");
});

$("#closePassword2").click( function(e){
	e.preventDefault();
	unsetPasswordErrors( "new-password");
	unsetPasswordErrors( "old-password");
	unsetPasswordErrors( "old-verify");
	$("input[name='new-password']").val("");
	$("input[name='old-password']").val("");
	$("input[name='old-verify']").val("");
});


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

$('body').on('click', 'a.remove-salidaproducto', function(e) {
	$( ".confirm-delete" , "#userDeleteModal").removeAttr("field");
	var id = $(this).parent().parent().attr("id");
	unsetPasswordErrors("password_delete");
	$("input[name='password_delete']").val("");
	var user = $(this).parent().parent().parent().parent().children().eq(0).text();
	$("#userDeleteModal").hide().show();
	$("#userDeleteModal").modal();
	if (user.length = 1) {
		$("#message").text("esta salida?");
		$(".variable").text("");
		$(".entity").text("");
	} else {
		$("#message").text("estas salidas");
		$(".variable").text("");
		$(".entity").text("");
	}
	$(".confirm-delete", "#userDeleteModal").attr("id", "delete-" + id);
});


$('body').on('click', 'button.confirm-delete', function( e ) {
	e.preventDefault();
	var id  = $(this).attr("id").replace("delete-", "");

	var td  = $("#"+id);

	/*var url = "pos_3/salidaproducto/destroy/"+id;*/
	var url = "salidaproducto/destroy/"+id;
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
		$(".user-created-message > p").text("Salida de Producto borrada exitosamente!");
		salidaproducto_table.ajax.reload();
		$("#userDeleteModal").modal("hide");
	}).fail(function(errors) {
		var errors = JSON.parse(errors.responseText);
		if (errors.password_delete != null) setPassworddErrors("password_delete", errors.password_delete);
		else unsetPasswordErrors("password_delete");
	});
	return false;

});