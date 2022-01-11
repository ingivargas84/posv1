$(document).on("keypress", 'form', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});


$('body').on('click', 'a.edit-product', function(e) {
	e.preventDefault();
	$("#productoUpdateModal").modal();
	$("#productoUpdateModal").hide().show();
	$("#password-changed").addClass("hidden");
	var id = $(this).parent().parent().attr("id");
	
	var url= "producto/name/"+id;
	$.getJSON( url , function ( data ) {
		$('#edit-producto-form').data("id", id);
		$("#edit-producto-form input[name='codigobarra']").val( data.codigobarra);
		$("#edit-producto-form input[name='prod_nombre']").val( data.prod_nombre);
		$("#edit-producto-form input[name='minimo']").val( data.edo_producto_id);
		$("#edit-producto-form input[name='precio_venta']").val( data.precio_venta);
		var tipo_venta_id = data.edo_producto_id;
		$('#tipo_venta_id option').each(function(option) {
			if (this.value == tipo_venta_id) {
				$(this).parent().val( this.value );
				return false;
			}
		});
	});
});


$("#edit-producto-form").submit(function(e) {
	e.preventDefault();
	var id = $(this).data("id");
	
	var url = "producto/" + id + "/update";
	var codigobarra = $("#edit-producto-form input[name='codigobarra']").val();
	var prod_nombre = $("#edit-producto-form input[name='prod_nombre']").val();
	var precio_venta = $("#edit-producto-form input[name='precio_venta']").val();
	var edo_producto_id =$("#tipo_venta_id").val();
	data = {
		codigobarra: codigobarra,
		prod_nombre: prod_nombre,
		precio_venta : precio_venta, 
		edo_producto_id : edo_producto_id
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
		$(".user-created-message > p").text("Producto editado exitosamente!");
		$('#productoUpdateModal').modal("hide");
		producto_table.ajax.reload();
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


$('body').on('click', 'a.remove-producto', function(e) {
	$( ".confirm-delete" , "#userDeleteModal").removeAttr("field");
	var id = $(this).parent().parent().attr("id");
	unsetPasswordErrors("password_delete");
	$("input[name='password_delete']").val("");
	var user = $(this).parent().parent().parent().parent().children().eq(0).text();
	$("#userDeleteModal").hide().show();
	$("#userDeleteModal").modal();
	if (user.length = 1) {
		$("#message").text("este producto?");
		$(".variable").text("");
		$(".entity").text("");
	} else {
		$("#message").text("estos productos");
		$(".variable").text("");
		$(".entity").text("");
	}
	$(".confirm-delete", "#userDeleteModal").attr("id", "delete-" + id);
});


$('body').on('click', 'button.confirm-delete', function( e ) {
	e.preventDefault();
	var id  = $(this).attr("id").replace("delete-", "");

	var td  = $("#"+id);

	var url = "producto/destroy/"+id;
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
		$(".user-created-message > p").text("Producto borrado exitosamente!");
		producto_table.ajax.reload();
		$("#userDeleteModal").modal("hide");
	}).fail(function(errors) {
        var errors = JSON.parse(errors.responseText);
        if (errors.password_delete != null) setPassworddErrors("password_delete", errors.password_delete);
        else unsetPasswordErrors("password_delete");
    });
	return false;
});