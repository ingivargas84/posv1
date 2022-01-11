$('#password-changed').on('close.bs.alert', function ( e ) {
	e.preventDefault();
	$(this).fadeOut();
	return false;
});

$('body').on('click', 'a.remove-venta', function(e) {
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

$('body').on('click', 'a.edit-venta', function(e) {
	e.preventDefault();
	$("#ventaUpdateModal").modal();
	$("#ventaUpdateModal").hide().show();
	$("#password-changed").addClass("hidden");
	var id = $(this).parent().parent().attr("id");
	/*var url= "/pos_v3/tipoventa/"+id;*/
	var url= "tipoventa/"+id;
	$.getJSON( url , function ( data ) {
		$('#edit-venta-form').data("id", id);
		var tipo_venta_id = data.tipo_venta_id;
		$('#tipo_venta_id option').each(function(option) {
			if (this.value == tipo_venta_id) {
				$(this).parent().val( this.value );
				return false;
			}
		});
	});
});

$('body').on('click', 'a.detalle-venta', function(e) {
	e.preventDefault();
	var id = $(this).parent().parent().attr("id");
	/*window.location = "/pos_v3/ventadetalle/"+ id;*/
	window.location = "/ventadetalle/"+ id;
});

$("#edit-venta-form").submit(function(e) {
	e.preventDefault();
	var id = $(this).data("id");
	/*var url = "/pos_v3/venta/" + id + "/update";*/
	var url = "venta/" + id + "/update";
	var tipo_venta_id = $("#edit-venta-form #tipo_venta_id").val();

	data = {
		tipo_venta_id: tipo_venta_id
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
		$(".user-created-message > p").text("Venta edita exitosamente!");
		$('#ventaUpdateModal').modal("hide");
		venta_table.ajax.reload();
	}).fail(function(errors) {
        // var errors = JSON.parse(errors.responseText);
        // if (errors.name != null) setFieldErrorsUpdate("name", errors.name[0]);
        // else unsetFieldErrorsUpdate("name");
        // if (errors.email != null) setFieldErrorsUpdate("email", errors.email[0]);
        // else unsetFieldErrorsUpdate("email");
    });
	return false;
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

$('body').on('click', 'button.confirm-delete', function( e ) {
	e.preventDefault();
	var id  = $(this).attr("id").replace("delete-", "");

	var td  = $("#"+id);

	/*var url = "/pos_v3/partidaajuste/destroy/detalle/"+id;*/
	var url = "/partidaajuste/destroy/detalle/"+id;
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
		$(".user-created-message > p").text("Registro borrado exitosamente!");
		partida_detalle.ajax.reload();
		$("#userDeleteModal").modal("hide");
	}).fail(function(errors) {
		var errors = JSON.parse(errors.responseText);
		if (errors.password_delete != null) setPassworddErrors("password_delete", errors.password_delete);
		else unsetPasswordErrors("password_delete");
	});
	return false;
});
