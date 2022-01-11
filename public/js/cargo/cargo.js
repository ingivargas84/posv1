var user_table = $('#cargo-table').DataTable({
    "ajax": "cargo/getJson",
    "responsive": true,
    "processing": true,
    "serverSide": true,
    "info": true,
    "showNEntries": true,
    "paging": true,
    "order": [0, 'asc'],
    "columns": [{
        "title": "Id",
        "data": "id",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.fitTextHTML(data);
        },
    }, {
        "title": "Cargo",
        "data": "cargo",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return CustomDatatableRenders.datetimeHTML(data);
        },
    }, {
        "title": "Actions",
        "orderable": false,
        "render": function(data, type, full, meta) {
            return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-left two-columns'>" + 
            "<a href='#' class='edit-task' id='edit-task'>" + 
            "<i class='fa fa-btn fa-edit' title='Edit'></i>" + 
            "</a>" + "</div>" + "<div class='float-right two-columns'>" + 
            "<a href='#' class='remove-task'>" + "<i class='fa fa-btn fa-trash' title='Delete'></i>" + "</a>" + "</div>" + "</div>";;
        },
        "responsivePriority": 2
    }],
    "createdRow": function(row, data, rowIndex) {
        $.each($('td', row), function(colIndex) {
            if (colIndex == 3) $(this).attr('id', data.id);
        });
    },
    "fnPreDrawCallback": function( oSettings ) {
    }
});
