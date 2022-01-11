 $('#fecha_inicio').datetimepicker({
        format: 'DD-MM-YYYY',
        showClear: true,
        showClose: true
    });
        $('#fecha_final').datetimepicker({
        format: 'DD-MM-YYYY',
        showClear: true,
        showClose: true
    });


var salida_table = $('#salida-table').DataTable({
    /*"ajax": "/pos_v3/salida/getJson",*/
    "ajax": "salida/getJson",
    "responsive": true,
    "processing": true,
    "serverSide": true,
    "info": true,
    "bSort" : false,
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
        "title": "Fecha",
        "data": "Fecha_Salida",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Código",
        "data": "Codigo",
        "width" : "15%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Producto",
        "data": "Producto",
        "width" : "25%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Tipo Salida",
        "data": "Tipo_Salida",
        "width" : "10%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
           return CustomDatatableRenders.fitTextHTML(data);   
       },
   }, {
        "title": "Cantidad",
        "data": "Cantidad",
        "width" : "10%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
           return CustomDatatableRenders.fitTextHTML(data);   
       },
   }, {
        "title": "Precio Costo",
        "data": "PrecioCompra",
        "width" : "15%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
           return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));  
       },
   },{
    "title": "Total Neto",
    "data": "Total_Neto",
    "width" : "15%",
    "responsivePriority": 5,
    "render": function( data, type, full, meta ) {
        return CustomDatatableRenders.fitTextHTML("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));
    },
}],
"createdRow": function(row, data, rowIndex) {
    $.each($('td', row), function(colIndex) {
        if (colIndex == 4) $(this).attr('id', data.id);
    });
},
"fnPreDrawCallback": function( oSettings ) {
}
});