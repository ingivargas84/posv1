$('body').on('click', 'a.edit-empleado', function(e) {
	e.preventDefault();
	$("#empleadoUpdateModal").modal();
	$("#empleadoUpdateModal").hide().show();
	$("#password-changed").addClass("hidden");
	var id = $(this).parent().parent().attr("id");
	var url= "empleado/name/"+id;
	$.getJSON( url , function ( data ) {
		$('#edit-empleado-form').data("id", id);
		$("#edit-empleado-form input[name='emp_direccion']").val( data.emp_direccion);
		$("#edit-empleado-form input[name='emp_telefonos']").val( data.emp_telefonos);
		$("#edit-empleado-form input[name='cargo_id']").selectpicker('val', cargo_id);
	});
});


$("#edit-empleado-form").submit(function(e) {
	e.preventDefault();
	var id = $(this).data("id");
	var url = "empleado/" + id + "/update";
	var emp_direccion = $("#edit-empleado-form input[name='emp_direccion']").val();
	var emp_telefonos = $("#edit-empleado-form input[name='emp_telefonos']").val();
	var cargo_id = $("#edit-empleado-form #cargo_id").val();
	data = {
		emp_direccion: emp_direccion,
		emp_telefonos: emp_telefonos,
		cargo_id: cargo_id,
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
		$(".user-created-message > p").text("Empleado editado exitosamente!");
		$('#empleadoUpdateModal').modal("hide");
		empleado_table.ajax.reload();
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


$('body').on('click', 'a.remove-empleado', function(e) {
	$( ".confirm-delete" , "#userDeleteModal").removeAttr("field");
	var id = $(this).parent().parent().attr("id");
	unsetPasswordErrors("password_delete");
	$("input[name='password_delete']").val("");
	var user = $(this).parent().parent().parent().parent().children().eq(0).text();
	$("#userDeleteModal").hide().show();
	$("#userDeleteModal").modal();
	if (user.length = 1) {
		$("#message").text("este empleado?");
		$(".variable").text("");
		$(".entity").text("");
	} else {
		$("#message").text("estos empleados");
		$(".variable").text("");
		$(".entity").text("");
	}
	$(".confirm-delete", "#userDeleteModal").attr("id", "delete-" + id);
});


$('body').on('click', 'button.confirm-delete', function( e ) {
	e.preventDefault();
	var id  = $(this).attr("id").replace("delete-", "");

	var td  = $("#"+id);

	var url = "empleado/destroy/"+id;
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
		$(".user-created-message > p").text("Empleado borrado exitosamente!");
		empleado_table.ajax.reload();
		$("#userDeleteModal").modal("hide");
	}).fail(function(errors) {
        var errors = JSON.parse(errors.responseText);
        if (errors.password_delete != null) setPassworddErrors("password_delete", errors.password_delete);
        else unsetPasswordErrors("password_delete");
    });
	return false;

});