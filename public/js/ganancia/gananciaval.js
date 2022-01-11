$(document).ready(function() {

    var validator = $("#submit-empleado").validate({
        ignore: [],
        onkeyup:false,
        rules: {
            fecha_inicio: {
                required:true
            },
        fecha_final: {
            required : true,

        }
    },
    messages: {
        fecha_inicio: {
            required: "Por favor, ingrese la fecha de inicio"
        },
        fecha_final: {
            required : "Por favor, ingrese la fecha final"
        }
    }
});

});