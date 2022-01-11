var cuentaxcobrar_table = $('#cuentaxcobrar-table').DataTable({
    "ajax": "cuentaxcobrar/getJson",
    "responsive": true,
    "processing": true,
    "serverSide": true,
    "info": true,
    "showNEntries": true,
    "paging": true,
    "language": {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
    },
    "order": [0, 'desc'],
    "columns": [ {
        "title": "Empleado",
        "data": "nombrec",
        "width" : "25%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Total",
        "data": "total_venta",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));
        },
    }, {
        "title": "Usuario",
        "data": "name",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },{
        "title": "Actions",
        "orderable": false,
        "render": function(data, type, full, meta) {
            return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-right one-columns'>" + 
            "<a href='#' class='detalle-venta'>" + 
            "<i class='fa fa-btn fa-desktop' title='detalle'></i>" + 
            "</div>" + "</div>";;
        },
        "responsivePriority": 2
    }],
    "createdRow": function(row, data, rowIndex) {
        $.each($('td', row), function(colIndex) {
            if (colIndex == 4) $(this).attr('id', data.id);
        });
    },
    "fnPreDrawCallback": function( oSettings ) {
    }
});

var detalle = $('#detalle').text();


$('#addpago').on('click', function(e) {
    e.preventDefault();
    $("#cuentaxCobrarModal").modal();
    $("#cuentaxCobrarModal").hide().show();
});

$("#empleado_id").change(function() {
    if ($("#empleado_id").val() != 0) {
        var empleado = $("#empleado_id").val();
        var urlApiType = "/getSaldo/" + "?empleado=" + empleado;
        $.ajax({
            method: "GET",
            url: urlApiType,
            contentType: "application/json",
        }).done(function(data) {
            if (data == "") {
                $("#saldo").val("0.00");
            }
            else {
              $("#saldo").val(data[0].saldo);  
          }
      }).fail(function(errors) {});
        return false;
    } else if ($("#empleado_id").val() == 0) {
        $("#saldo").text("0.00");

    }
});


$("#edit-producto-form").submit(function(e) {
    e.preventDefault();
    var id = $("#empleado_id").val();
    var url = "cuentaxcobrar/" + id + "/update";
    var monto = $("#edit-producto-form input[name='monto']").val();
    var saldo = $("#edit-producto-form input[name='saldo']").val();
    var empleado_id = $("#empleado_id").val();
    data = {
        monto: monto,
        saldo: saldo,
        empleado_id: empleado_id
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
        $(".user-created-message > p").text("Pago Aplicado correctamente!");
        $('#cuentaxCobrarModal').modal("hide");
    }).fail(function(errors) {
    
    });
    return false;
});

$("#closeEditUser").click( function(e){
    e.preventDefault();
    $("input[name='monto']").val("");
    $("input[name='saldo']").val("");
});

$("#closeEditUser2").click( function(e){
    e.preventDefault();
    $("input[name='monto']").val("");
    $("input[name='saldo']").val("");
});



var cuentaxcobrar_detalle = $('#cuentaxcobrardetalle-table').DataTable({
    "ajax": "/cuentaxcobrardetalle/"+detalle +"/getJson",
    "responsive": true,
    "processing": true,
    "serverSide": true,
    "info": true,
    "showNEntries": true,
    "paging": true,
    "language": {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
    },
    "order": [0, 'desc'],
    "columns": [ {
        "title": "Producto",
        "data": "prod_nombre",
        "width" : "25%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Cantidad",
        "data": "cantidad",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Subtotal",
        "data": "subtotal",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
           return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));

       },
   },

],
"createdRow": function(row, data, rowIndex) {
    $.each($('td', row), function(colIndex) {
        if (colIndex == 4) $(this).attr('id', data.id);
    });
},
"fnPreDrawCallback": function( oSettings ) {
}
});
