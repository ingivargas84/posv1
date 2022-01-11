$('body').on('click', 'a.edit-proveedor', function(e) {
	e.preventDefault();
	$("#proveedorUpdateModal").modal();
	$("#proveedorUpdateModal").hide().show();
	$("#password-changed").addClass("hidden");
	var id = $(this).parent().parent().attr("id");
	/*var url= "/pos_v3/proveedor/name/"+id;*/
	var url= "proveedor/name/"+id;
	$.getJSON( url , function ( data ) {
		$('#edit-proveedor-form').data("id", id);
		$("#edit-proveedor-form input[name='nombre_comercial']").val( data.nombre_comercial);
		$("#edit-proveedor-form input[name='telefonos']").val( data.telefonos);
	});
});


$("#edit-proveedor-form").submit(function(e) {
	e.preventDefault();
	var id = $(this).data("id");
	/*var url = "/pos_v3/proveedor/" + id + "/update";*/
	var url = "proveedor/" + id + "/update";
	var nombre_comercial = $("#edit-proveedor-form input[name='nombre_comercial']").val();
	var telefonos = $("#edit-proveedor-form input[name='telefonos']").val();
	data = {
		nombre_comercial: nombre_comercial,
		telefonos: telefonos,
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
		$(".user-created-message > p").text("Proveedor editado exitosamente!");
		$('#proveedorUpdateModal').modal("hide");
		proveedor_table.ajax.reload();
	}).fail(function(errors) {
        // var errors = JSON.parse(errors.responseText);
        // if (errors.name != null) setFieldErrorsUpdate("name", errors.name[0]);
        // else unsetFieldErrorsUpdate("name");
        // if (errors.email != null) setFieldErrorsUpdate("email", errors.email[0]);
        // else unsetFieldErrorsUpdate("email");
    });
	return false;
});


$('#password-changed').on('close.bs.alert', function ( e ) {
	e.preventDefault();
	$(this).fadeOut();
	return false;
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


$('body').on('click', 'a.remove-proveedor', function(e) {
	$( ".confirm-delete" , "#userDeleteModal").removeAttr("field");
	unsetPasswordErrors("password_delete");
	$("input[name='password_delete']").val("");
	var id = $(this).parent().parent().attr("id");
	var user = $(this).parent().parent().parent().parent().children().eq(0).text();
	$("#userDeleteModal").hide().show();
	$("#userDeleteModal").modal();
	if (user.length = 1) {
		$("#message").text("este proveedor?");
		$(".variable").text("");
		$(".entity").text("");
	} else {
		$("#message").text("estos proveedores");
		$(".variable").text("");
		$(".entity").text("");
	}
	$(".confirm-delete", "#userDeleteModal").attr("id", "delete-" + id);
});


$('body').on('click', 'button.confirm-delete', function( e ) {
	e.preventDefault();
	var id  = $(this).attr("id").replace("delete-", "");

	var td  = $("#"+id);

	/*var url = "/pos_v3/proveedor/destroy/"+id;*/
	var url = "proveedor/destroy/"+id;
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
		$(".user-created-message > p").text("Proveedor borrado exitosamente!");
		producto_table.ajax.reload();
		$("#userDeleteModal").modal("hide");
	}).fail(function(errors) {
		var errors = JSON.parse(errors.responseText);
		if (errors.password_delete != null) setPassworddErrors("password_delete", errors.password_delete);
		else unsetPasswordErrors("password_delete");
	});
	return false;

});