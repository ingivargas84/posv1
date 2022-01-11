    $("input[name='codigobarra']").focusout(function() {
        var codigo = $("input[name='codigobarra'] ").val();
        var url = "/venta/get/?data=" + codigo;
        /*var url = "../pos/venta/get/?data=" + codigo;*/
        $.getJSON( url , function ( result ) {
            if (result == 0 ) {
                $("input[name='descripcion'] ").val("");
                $("input[name='precio_venta'] ").val("");
                $("input[name='cantidad'] ").val(1);
            }
            else {
                $("input[name='descripcion'] ").val(result[0].prod_nombre);
                $("input[name='precio_venta'] ").val(result[0].precio_venta);
                $("input[name='cantidad'] ").val(1);
                $("input[name='producto_id'] ").val(result[0].producto_id);
            }
        });
    });

    $("input[name='efectivo']").focusout(function() {
        var total = $("input[name='total'] ").val();
        var efectivo = $("input[name='efectivo']").val();
        var cambio = efectivo - total;
        $("input[name='cambio'] ").val("Q."+ cambio);
    });


$("input[name='cantidad']").focusout(function() {
    var cantidad = $("input[name='cantidad'] ").val();
    var precio_venta = $("input[name='precio_venta'] ").val();

    var subtotal = cantidad * precio_venta;
    if (cantidad != 0 ) {
        $("input[name='subtotal'] ").val(subtotal);
    }
    else 
        $("input[name='subtotal'] ").val("0");
    return false;
})

$('body').on('click', '#addDetalle', function(e) {

    var detalle = new Object();
    var cantidad = $("input[name='cantidad'] ").val();
    var precio_venta = $("input[name='precio_venta'] ").val();
    var subtotal = cantidad * precio_venta;
    $("input[name='subtotal'] ").val(subtotal);
    detalle.cantidad = $("input[name='cantidad'] ").val();
    detalle.precio_venta = $("input[name='precio_venta'] ").val();
    detalle.subtotal = $("input[name='subtotal'] ").val();
    detalle.producto_id  = $("input[name='producto_id'] ").val();
    detalle.codigoballa = $("input[name='codigobarra'] ").val();
    detalle.prod_nombre = $("input[name='descripcion'] ").val();
    var total2 = $("input[name='total'] ").val();
    if (total2 != "") {
        var total2 =parseFloat(total2);
        var subtotal = parseFloat(subtotal);
        var total = total2 + subtotal;
        var total3 = $("input[name='total'] ").val(total);
    }
    else {
        var subtotal = parseFloat(subtotal);
        var total3 = $("input[name='total'] ").val(subtotal);
    }

    db.links.push(detalle);
    $("input[name='producto_id'] ").val("");
    $("input[name='codigobarra'] ").val("");
    $("input[name='descripcion'] ").val("");
    $("input[name='precio_venta'] ").val("");
    $("input[name='cantidad'] ").val(1);
    var cantidad = $("input[name='cantidad'] ").val();
    var precio_venta = $("input[name='precio_venta'] ").val();
    var subtotal = cantidad * precio_venta;
    $("input[name='subtotal'] ").val(subtotal);
    $("#detalle-grid .jsgrid-search-button").trigger("click");
});


(function() {

    var db = {

        loadData: function(filter) {
            return $.grep(this.links, function(link) {
                return (!filter.name || link.name.indexOf(filter.name) > -1)
                && (!filter.url || link.url.indexOf(filter.url) > -1);
            });
        },

        insertItem: function(insertingLink) {
            this.links.push(insertingLink);
            console.log(insertingLink);
        },

        updateItem: function(updatingLink) {
            console.log(updatingLink);
        },

        deleteItem: function(deletingLink) {
            var linkIndex = $.inArray(deletingLink, this.links);
            var total2 = $("input[name='total'] ").val();
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(deletingLink.subtotal_venta);
            var total = total2 - subtotal;
            var total3 = $("input[name='total'] ").val(total);
            this.links.splice(linkIndex, 1);
        }

    };
    window.db = db;
    db.links = [];


    function saveDetalle(button) {
        var total_x_cobrar = $("input[name='total'] ").val();
        var tipo_venta_id = $("#tipo_venta_id").val();
        var empleado_id = $("#empleado_id").val();
        var formData = {total_x_cobrar: total_x_cobrar, tipo_venta_id : tipo_venta_id, empleado_id : empleado_id} 
        $.ajax({
            type: "GET",
            url: "/cuentaxcobrar/save/",
            data: formData,
            dataType: "json",
            success: function(data) {
                var detalle = data;
                $.ajax({
                    url: "/cuentaxcobrar-detalle/" + detalle.id,
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify(db.links),
                    success: function(addressResponse) {
                        if (addressResponse.result == "ok") {
                            window.location = "/cuentaxcobrar"
                        }
                    },
                    always: function() {
                    }
                });
            },
            error: function() {
                alert("Something went wrong, please try again!");
            }
        });
    }

    $("#ButtonDetalle").click(function(event) {
        saveDetalle();
    });


    $(document).ready(function () {

        $("#detalle-grid").jsGrid({
            width: "",
            filtering: false,
            editing: false,
            sorting: true,
            paging: true,
            autoload: true,
            inserting: false,
            pageSize: 20,
            pagerFormat: "Pages: {prev} {pages} {next} | {pageIndex} of {pageCount} |",
            pageNextText: '>',
            pagePrevText: '<',
            deleteConfirm: "Esta seguro de borrar el producto",
            controller: db,
            fields: [
                // { title: "Id", name: "id", type:"number", index:"id", filtering:false, editing:false, inserting:false},
                { title: "Producto", name: "prod_nombre", type: "text"},
                { title: "C贸digo", name: "producto_id", type: "text", visible:false},
                { title: "Cantidad", name: "cantidad", type: "text"},
                { title: "Precio", name: "precio_venta", type: "text"},
                { title: "Subtotal", name: "subtotal", type: "text"},
                { type: "control" }
                ],
                onItemInserting: function (args) {
                },
                onItemUpdating: function (object) {
                },
                onRefreshed : function () {
                    $('tbody').children('.jsgrid-insert-row').children('td').children('input').first().focus();
                }
            });
    });
}());