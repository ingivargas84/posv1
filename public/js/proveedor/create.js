$(document).ready(function() {


	$.validator.addMethod("ntel", function(value, element) {
		var valor = value.length;
		if (valor == 8)
		{
			return true;
		}
		else
		{
			return false;
		}
	}, "Debe ingresar el número de teléfono con 8 dígitos, en formato ########");


	function ValidaNIT(txtN) {
		if (isNaN(txtN)){
			return false;
		}

		txtN = txtN.toUpperCase();
		if (txtN == "CF" || txtN == "C/F") return true;
		var nit = txtN;
		var pos = nit.indexOf("-");

		if (pos < 0)
		{
			var correlativo = txtN.substr(0, txtN.length - 1);
			correlativo = correlativo + "-";

			var pos2 = correlativo.length - 2;
			var digito = txtN.substr(pos2 + 1);
			nit = correlativo + digito;
			pos = nit.indexOf("-");
			txtN = nit;
		}

		var Correlativo = nit.substr(0, pos);
		var DigitoVerificador = nit.substr(pos + 1);
		var Factor = Correlativo.length + 1;
		var Suma = 0;
		var Valor = 0;
		for (x = 0; x <= (pos - 1); x++) {
			Valor = eval(nit.substr(x, 1));
			var Multiplicacion = eval(Valor * Factor);
			Suma = eval(Suma + Multiplicacion);
			Factor = Factor - 1;
		}
		var xMOd11 = 0;
		xMOd11 = (11 - (Suma % 11)) % 11;
		var s = xMOd11;
		if ((xMOd11 == 10 && DigitoVerificador == "K") || (s == DigitoVerificador)) {
			return true;
		}
		else {
			return false; 
		}

	}


	$.validator.addMethod("nit", function(value, element) {
		var valor = value;
		if (ValidaNIT(valor) == true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}, "El NIT ingresado es incorrecto o inválido, elimine el guión y vuelva a ingresarlo");



	var validator = $("#submit-proveedor").validate({
		ignore: [],
		onkeyup:false,
		rules: {
			nit: {
				required : true,
				nit : true
			},
			nombre_comercial: {
				required : true,
			},
			telefonos: {
				required : true,
				ntel : true
			}
		},
		messages: {
			nit: {
				required: "Por favor, ingresa un NIT, sin colocar guión"
			},
			nombre_comercial : {
				required : "Por favor, ingresa un nombre comercial o marca"
			},
			telefonos : {
				required : "Por favor, ingresa un número de teléfono"
			}
		}
	});

});