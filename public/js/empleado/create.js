$(document).ready(function() {

    var validator = $("#submit-empleado").validate({
        ignore: [],
        onkeyup:false,
        rules: {
            emp_cui: {
                required:true
            },
            emp_nombres: {
               required : true
           },
           emp_apellidos: {
            required : true
        },
        emp_direccion : {
            required : true
        },
        emp_telefonos : {
            required : true
        },
        cargo_id : {
            required : true,

        }
    },
    messages: {
        emp_cui: {
            required: "Por favor, ingrese el CUI o DPI"
        },
        emp_nombres : {
            required : "Por favor, ingrese los nombres"
        },
        emp_apellidos : {
            required : "Por favor, ingrese los apellidos"
        },
        emp_direccion : {
             required : "Por favor, ingrese una dirección"
        },
        emp_telefonos : {
             required : "Por favor, ingrese un teléfono"
        },
        cargo_id : {
            required : "Por favor, seleccione el cargo"
        }
    }
});

});