var ingresoproducto_table = $('#ingresoproducto-table').DataTable({
    /*"ajax": "/pos_v3/ingresoproducto/getJson",*/
    "ajax": "ingresoproducto/getJson",
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
        "title": "Cod",
        "data": "id",
        "width" : "5%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },{
       "title": "Serie Factura",
        "data": "serie_factura",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },{
        "title": "Num Factura",
        "data": "num_factura",
        "width" : "15%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Fecha Factura",
        "data": "fecha_factura",
        "width" : "20%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },{
        "title": "Proveedor",
        "data": "nombre_comercial",
        "width" : "20%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },{
        "title": "Total Factura",
        "data": "total",
        "width" : "20%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML("Q. " + parseFloat(Math.round(data * 100) / 100).toFixed(2));
        },
    }, {
        "title": "Actions",
        "width" : "10%",
        "orderable": false,
        "render": function(data, type, full, meta) {
            return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-left three-columns'>" + 
            "<a href='#' class='edit-ingresoproducto'>" + 
            "<i class='fa fa-btn fa-edit' title='Edit'></i>" + 
            "</div>" + "<div class='float-right three-columns'>" + 
            "<a href='#' class='remove-ingresoproducto'>" + 
            "<i class='fa fa-btn fa-trash' title='Delete'></i>" + 
            "</a>" + "</div>" + "<div class='float-left three-columns'>" + 
            "<a href='#' class='detalle-ingresoproducto'>" + 
            "<i class='fa fa-btn fa-desktop' title='Detalles'></i>" + 
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



var detalle = $('#detalleingreso').text();

var venta_detalle = $('#ingresodetalle-table').DataTable({
    /*"ajax": "/pos_v3/ingresodetalle/"+ detalle +"/getJson",*/
    "ajax": "/ingresodetalle/"+ detalle +"/getJson",
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
    "columns": [ {
        "title": "No de Compra",
        "data": "ingreso_maestro_id",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Codigo Barra",
        "data": "codigobarra",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    },{
        "title": "Producto",
        "data": "prod_nombre",
        "width" : "25%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Cantidad",
        "data": "existencias",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Precio de Compra",
        "data": "precio_compra",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));
        },
    }, {
        "title": "Precio de Venta",
        "data": "precio_venta",
        "width" : "15%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
           return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));

       },
   },{
    "title": "Actions",
    "width" : "10%",
    "orderable": false,
    "render": function(data, type, full, meta) {
        return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-center three-columns'>" + 
            "<a href='#' class='remove-ingresodetalle'>" + 
            "<i class='fa fa-btn fa-trash' title='Delete'></i>" + 
            "</a>" + "</div>" + "</div>";;
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
