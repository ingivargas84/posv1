$(document).ready(function() {

    $(document).on("keypress", 'form', function (e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            e.preventDefault();
            return false;
        }
    });


    $.validator.addMethod("NombreUnico", function(value, element) {
        var valid = false;
        $.ajax({
            type: "GET",
            async: false,
            url: "/nombre-disponible/" + value,
            dataType: "json",
            success: function(msg) {
                valid = !msg;
            }
        });
        return valid;
    }, "El nombre de producto ya fue registrado en el sistema");


    $.validator.addMethod("CodigoBarra", function(value, element) {
        var valid = false;
        $.ajax({
            type: "GET",
            async: false,
            url: "/codigo-barra/" + value,
            dataType: "json",
            success: function(msg) {
                valid = !msg;
            }
        });
        return valid;
    }, "El c√≥digo de barra ya fue registrado en el sistema");



    var validator = $("#submit-producto").validate({
        ignore: [],
        onkeyup:false,
        rules: {
            prod_nombre: {
                required : true
            },
            codigobarra: {
                required : true,
                CodigoBarra : true
            },
            precio_venta: {
                required : true
            },
            minimo : {
                required : true,
            }
    },
    messages: {
        prod_nombre: {
            required: "Por favor, ingresa un nombre"
        },
        codigobarra : {
            required : "Por favor, ingrese un c®Ædigo de barra"
        },
        precio_venta : {
            required : "Por favor, ingrese el precio de venta"
        },       
       minimo : {
        required : "Por favor, ingrese una cantidad"
    }
}
});

});