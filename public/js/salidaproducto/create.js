$(document).ready(function() {

    $('#fecha_salida').datetimepicker({
        format: 'DD-MM-YYYY',
        showClear: true,
        showClose: true
    });

    var validator = $("#submit-salidaproducto").validate({
        ignore: [],
        onkeyup:false,
        rules: {
            producto_id: {
                required:true
            },
            cantidad_salida: {
               required : true
           },
           fecha_salida: {
            required : true
        },
        tipo_salida_id : {
            required : true,
        }

    },
    messages: {
        producto_id: {
            required: "Por favor, seleccione un producto"
        },
        cantidad_salida : {
            required : "Por favor, ingresa una cantidad"
        },
        fecha_salida : {
            required : "Por favor, seleccione la fecha de salida"
        },
        tipo_salida_id : {
            required : "Por favor, seleccione el tipo de salida",
        }
    }
});

});