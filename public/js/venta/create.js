$(document).on("keypress", 'form', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

$(document).on("keypress", '#addDetalle', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});


$(document).on("keypress", '#ButtonDetalle', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

$.ajax({
    method: "GET",
    url: "/../venta/getProductos/",
    async: true,
    contentType: "application/json"
}).done(function (data) {
    $("#producto_id").html("");
    $("#producto_id").selectpicker('refresh')
    $.each(data, function (id, data) {
        var opt = $('<option />');
        opt.val(data.id);
        opt.text(data.codigobarra + ' - ' + data.prod_nombre);
        $('#producto_id').append(opt);
    });
    $("#producto_id").selectpicker('refresh');
}); 

$("#producto_id").change(function () {
    var codigo = $("#producto_id").val();
    var url = "/../venta/get/?data=" + codigo;
    $.getJSON( url , function ( result ) {
        if (result == 0 ) {
            $("input[name='descripcion'] ").val("");
            $("input[name='precio_venta'] ").val("");
            $("input[name='precio_compra'] ").val("");
            $("input[name='cantidad'] ").val(1);
            $("#total_existencia").text("El producto no existe, está agotado, en existencia mínima o desactivado");
        }
        else {
            $("input[name='descripcion'] ").val(result[0].prod_nombre);
            $("input[name='precio_venta'] ").val(result[0].precio_venta);
            $("input[name='precio_compra'] ").val(result[0].precio_compra);
            $("input[name='existencias'] ").val(result[0].existencias);
            $("input[name='cantidad'] ").val(1);
            $("input[name='movimiento_id'] ").val(result[0].producto_id);
            $("#total_existencia").text("La existencia del producto con el precio Q." + result[0].precio_venta + " es de:" + result[0].existencias);
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

$('body').on('click', '#addDetalle', function(e) 
{
    var l = Ladda.create( document.querySelector( '#addDetalle' ) );
    l.start();
    l.setProgress( 0.5 );
    if($("input[name='venta_maestro']").val() == "") 
    {
        var total_venta = $("input[name='total'] ").val();
        var tipo_venta_id = $("#tipo_venta_id").val();
        var formData = {total_venta: total_venta, tipo_venta_id : tipo_venta_id} 
        $.ajax({
            type: "GET",
            url: "/venta/save/",
            data: formData,
            async:false,
            dataType: 'json',
            success: function(data) {
                var detalle = data;
                $("input[name='venta_maestro'] ").val(data.id);
            },
            error: function() {
                alert("Something went wrong, please try again!");
            }
        });
    }

    if (parseInt($("input[name='existencias'] ").val()) >= parseInt($("input[name='cantidad'] ").val()))
    {

        if ($("input[name='descripcion'] ").val() != "" && $("input[name='cantidad'] ").val() != "")
        {

            var detalle = new Object();
            var cantidad = $("input[name='cantidad'] ").val();
            var precio_venta = $("input[name='precio_venta'] ").val();
            var subtotal = cantidad * precio_venta;
            $("input[name='subtotal'] ").val(subtotal);
            detalle.cantidad = $("input[name='cantidad'] ").val();
            detalle.precio_venta = $("input[name='precio_venta'] ").val();
            detalle.subtotal_venta = $("input[name='subtotal'] ").val();
            detalle.producto_id  = $("#producto_id").val();
            detalle.movimiento_id  = $("input[name='movimiento_id'] ").val();
            detalle.codigoballa = $("input[name='codigobarra'] ").val();
            detalle.prod_nombre = $("input[name='descripcion'] ").val();
            detalle.precio_compra = $("input[name='precio_compra'] ").val();
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

            dbs.detalles.push(detalle);
            $("input[name='codigobarra'] ").val("");
            $("input[name='descripcion'] ").val("");
            $("input[name='precio_venta'] ").val("");
            $("input[name='precio_compra'] ").val("");
            $("input[name='cantidad'] ").val(1);
            $.ajax({
                method: "GET",
                url: "/../venta/getProductos/",
                async: true,
                contentType: "application/json"
            }).done(function (data) {
                $("#producto_id").html("");
                $("#producto_id").selectpicker('refresh')
                $.each(data, function (id, data) {
                    var opt = $('<option />');
                    opt.val(data.id);
                    opt.text(data.codigobarra + ' - ' + data.prod_nombre);
                    $('#producto_id').append(opt);
                });
                $("#producto_id").selectpicker('refresh');
            }); 
            var cantidad = $("input[name='cantidad'] ").val();
            var precio_venta = $("input[name='precio_venta'] ").val();
            var subtotal = cantidad * precio_venta;
            $("input[name='subtotal'] ").val(subtotal);
            var venta_maestro = $("input[name='venta_maestro'] ").val();
            if($("input[name='venta_maestro']").val() != "") {       
                $.ajax({
                    url: "/venta-detalle/" + venta_maestro,
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify(dbs.detalles),
                    success: function(addressResponse) {
                        detalle.venta_detalle = addressResponse.id
                        db.links.push(detalle);
                        $("#detalle-grid .jsgrid-search-button").trigger("click");
                        dbs.detalles = "";
                        window.dbs = dbs;
                        dbs.detalles = [];

                    },
                    always: function() {
                    }
                });
            }
            $("#detalle-grid .jsgrid-search-button").trigger("click");
        }
        else {
            alert("Especifique un producto valido o cantidad");
        }
    }
    else {
        alert("No se puede realizar la venta, revise las existencias del producto");
    }
    l.stop();
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
            $.ajax({
                type: "DELETE",
                url: "/ventadetalle2/destroy/"+ deletingLink.venta_detalle+ "/" + deletingLink.movimiento_id,
                data: deletingLink,
                dataType: "json",
                success: function(data) {
                    var detalle = data;
                },
                error: function() {
                    alert("Something went wrong, please try again!");
                }
            });
            var linkIndex = $.inArray(deletingLink, this.links);
            var total2 = $("input[name='total'] ").val();
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(deletingLink.subtotal_venta);
            var total = total2 - subtotal;
            var total3 = $("input[name='total'] ").val(total);
            this.links.splice(linkIndex, 1);
        }

    };

    var dbs = {

        loadData: function(filter) {
            return $.grep(this.links, function(link) {
                return (!filter.name || link.name.indexOf(filter.name) > -1)
                && (!filter.url || link.url.indexOf(filter.url) > -1);
            });
        },

        insertItem: function(insertingLink) {
            this.detalles.push(insertingLink);
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
            this.detalles.splice(linkIndex, 1);
        }

    };
    window.db = db;
    window.dbs = dbs;
    db.links = [];
    dbs.detalles = [];


    function saveDetalle(button) {
        var total_venta = $("input[name='total'] ").val();
        var tipo_venta_id = $("#tipo_venta_id").val();
        var venta_maestro = $("input[name='venta_maestro'] ").val();
        var formData = {total_venta: total_venta, tipo_venta_id : tipo_venta_id} 
        $.ajax({
            type: "PATCH",
            url: "/venta/update-total/"+ venta_maestro+ "/",
            data: formData,
            dataType: "json",
            success: function(data) {
                var detalle = data;
                window.location = "/ventas"
            },
            error: function() {
                alert("Ha ocurrido un error, por favor pruebe de nuevo!");
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
                { title: "Producto", name: "prod_nombre", type: "text"},
                { title: "Código", name: "producto_id", type: "text", visible:false},
                { title: "Precio2", name: "precio_compra", type: "text", visible:false},
                { title: "venta_detalle", name: "venta_detalle", type: "text", visible:false},
                { title: "movimiento", name: "movimiento_id", type: "text", visible:false},
                { title: "Cantidad", name: "cantidad", type: "text"},
                { title: "Precio", name: "precio_venta", type: "text"},
                { title: "Subtotal", name: "subtotal_venta", type: "text"},
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