<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/construccion', 'HomeController@construccion');


Route::resource("/function", "FunctionController");

Route::group(array('middleware' => 'auth'), function()
{

    Route::patch( '/user/{user}/change' , 'UserController@changePassword' );
    Route::patch( '/user/{user}/changeInfo' , 'UserController@changeInformation' );

    Route::get('/rpt_existenciaprod', 'ProductoController@rpt_existenciasprod');
    Route::get('/existenciaprod/getJson', 'ProductoController@getJsonExistenciaProd');

    Route::get('/admin/salesData','HomeController@getSalesData')->name('dashboard.salesData');
    Route::get('/admin/purchaseData','HomeController@getPurchaseData')->name('dashboard.purchaseData');
    

    Route::group(array('middleware' => 'acl' , 'is' => 'superadmin|consulta' ), function()
    {
        /* ========== RUTAS DEL CRUD PARA USUARIOS =========== */
        Route::get( '/user' , 'UserController@index' );
        Route::get( '/user/getJson' , 'UserController@getJson' );
        Route::post( '/user/names' , 'UserController@getNames' );
        Route::post( '/user/store' , 'UserController@store' );
        Route::delete( '/user/destroy/{user}' , 'UserController@destroy' );
        Route::delete( '/user/multiple/destroy' , 'UserController@multipleDestroy' );
        Route::patch( '/user/{user}/update' , 'UserController@update' );
        Route::get( '/user/show/' , 'UserController@getInformationByUser');
        Route::get('/user/name/{user}', 'UserController@getName' );

         Route::get('/partidadetalle/{partidadetalle}/getJson' , 'PartidaAjusteController@getJson' );
        Route::get('/partidadetalle/{partidadetalle}', 'PartidaAjusteController@show');

        Route::get( '/partidamaestro' , 'PartidaMaestroController@index' );
        Route::get( '/partidamaestro/getJson' , 'PartidaMaestroController@getJson' );

        Route::get( '/partidamaestro/new' , 'PartidaMaestroController@create' );
        Route::delete( '/partidamaestro/destroy/{partida_maestro}/' , 'PartidaMaestroController@destroy' );
        Route::get( '/pdetalle/save/' , 'PartidaAjusteController@save');
        Route::post( '/partida-detalle/{partida_maestro}' , 'PartidaAjusteController@saveDetalle');
        Route::delete('/partidadetalle2/destroy/{partida_ajuste}/{movimiento_producto}', 'PartidaAjusteController@destroyDetalle2');
        Route::patch('/partida/update-total/{partida_maestro}/' , 'PartidaAjusteController@updateTotal');

        Route::delete('/partidaajuste/destroy/detalle/{partida_ajuste}/', 'PartidaAjusteController@destroyDetalle');

        Route::get('/ajuste', 'PartidaAjusteController@rpt_partida');
        Route::get('/partida/getJson', 'PartidaAjusteController@partidagetJson');
        Route::post('/pdf_ajustes', 'PdfController@pdf_ajustes');
    });


    Route::group(array('middleware' => 'acl' , 'is' => 'superadmin|administrator|consulta' ), function()
    {
        /* ========== RUTAS DEL CRUD PARA CARGOS =========== */
        Route::get( '/cargo' , 'CargoController@index' );
        Route::get( '/cargo/getJson' , 'CargoController@getJson' );

        /* ========== RUTAS DEL CRUD PARA PROVEEDORES =========== */
        Route::get( '/proveedor' , 'ProveedorController@index' );
        Route::get( '/proveedor/getJson' , 'ProveedorController@getJson' );
        Route::get( '/proveedor/new' , 'ProveedorController@create' );
        Route::post( '/proveedor' , 'ProveedorController@store' );
        Route::patch( '/proveedor/{proveedor}/update' , 'ProveedorController@update' );
        Route::resource("proveedor", "ProveedorController");
        Route::get('/proveedor/name/{proveedor}', 'ProveedorController@getName' );
        Route::delete( '/proveedor/destroy/{proveedor}' , 'ProveedorController@destroy' );

        /* ========== RUTAS DEL CRUD PARA PRODUCTOS =========== */
        Route::get( '/producto' , 'ProductoController@index' );
        Route::get( '/producto/getJson' , 'ProductoController@getJson' );
        Route::get( '/producto/new' , 'ProductoController@create' );
        Route::post( '/producto' , 'ProductoController@store' );
        Route::patch( '/producto/{producto}/update' , 'ProductoController@update' );
        Route::resource("producto", "ProductoController");
        Route::get('/producto/name/{producto}', 'ProductoController@getName' );
        Route::delete( '/producto/destroy/{producto}' , 'ProductoController@destroy' );
        Route::get('/nombre-disponible/{data}', 'ProductoController@nombreDisponible');
        Route::get('/codigo-barra/{data}', 'ProductoController@codigoDisponible');

        /* ========== RUTAS DEL CRUD PARA EMPLEADOS=========== */
        Route::get( '/cliente' , 'EmpleadoController@index' );
        Route::get( '/empleado/getJson' , 'EmpleadoController@getJson' );
        Route::get( '/empleado/new' , 'EmpleadoController@create' );
        Route::post( '/empleado' , 'EmpleadoController@store' );
        Route::patch( '/empleado/{empleado}/update' , 'EmpleadoController@update' );
        Route::resource("empleado", "EmpleadoController");
        Route::get('/empleado/name/{empleado}', 'EmpleadoController@getName' );
        Route::delete( '/empleado/destroy/{empleado}' , 'EmpleadoController@destroy' );

        /* ========== RUTAS DEL CRUD PARA INGRESO DE PRODUCTOS =========== */
        Route::get( '/ingresoproducto' , 'IngresoProductoController@index' );
        Route::get( '/ingresoproducto/getJson' , 'IngresoProductoController@getJson' );
        Route::get( '/ingresoproducto/new' , 'IngresoProductoController@create' );
        Route::get( '/ingresoproducto/save/' , 'IngresoProductoController@save');
        Route::post( '/ingresoproducto-detalle/{ingreso_maestro}' , 'IngresoProductoController@saveDetalle');
        Route::patch( '/ingresoproducto/{ingreso_maestro}/update' , 'IngresoProductoController@update' );
        Route::resource("ingresoproducto", "IngresoProductoController");
        Route::get('/ingresoproducto/name/{ingreso_maestro}', 'IngresoProductoController@getName' );
        Route::delete( '/ingresoproducto/destroy/{ingreso_maestro}' , 'IngresoProductoController@destroy' );
        Route::get('/ingresodetalle/{ingreso_maestro}', 'IngresoProductoController@show');
        Route::get( '/ingresodetalle/{ingreso_maestro}/getJson' , 'IngresoProductoController@getJsonDetalle' );
        Route::delete( '/ingresodetalle/destroy/{ingreso_detalle}' , 'IngresoProductoController@destroyDetalle' );
        Route::patch( '/ingresodetalle/{ingreso_maestro}/update' , 'IngresoProductoController@update' );
        Route::get('/ingresodetalle/name/{ingreso_detalle}', 'IngresoProductoController@getDetalle');

        /* ========== RUTAS DEL CRUD PARA SALIDAS DE PRODUCTOS =========== */
        Route::get( '/salidaproducto' , 'SalidaProductoController@index' );
        Route::get( '/salidaproducto/getJson' , 'SalidaProductoController@getJson' );
        Route::get( '/salidaproducto/new' , 'SalidaProductoController@create' );
        Route::post( '/salidaproducto' , 'SalidaProductoController@store' );
        Route::get('/tiposalida/{salida_producto}', 'SalidaProductoController@getTipoSalida');
        Route::patch( '/salidaproducto/{salidaproducto}/update' , 'SalidaProductoController@update' );
        Route::resource("salidaproducto", "SalidaProductoController");
        Route::get('/salidaproducto/name/{salidaproducto}
            ', 'SalidaProductoController@getName' );
        Route::delete( '/salidaproducto/destroy/{salidaproducto}' , 'SalidaProductoController@destroy' );

    });

Route::group(array('middleware' => 'acl' , 'is' => 'superadmin|consulta|consulta_central' ), function()
{
    Route::get('/rpt_ganancia', 'ProductoController@rpt_ganancia');
    Route::post('/pdf_ganancia', 'PdfController@pdf_ganancia');
    Route::get('/ganancia/getJson', 'ProductoController@getJsonGanancia');
    Route::get('/rpt_existencia', 'ProductoController@rpt_existencias');
    Route::get('/pdf_existencia', 'PdfController@pdf_existencia');
    Route::get('/pdf_cuentasxcobrar', 'PdfController@pdf_cuentasxcobrar');
    Route::get('/rpt_cuentasxcobrar', 'CuentaxCobrarController@rpt_cuentasxcobrar');
    Route::get( '/cuentasxcobrar/getJson' , 'CuentaxCobrarController@getJsonReporte');
    Route::post('/pdf_comprasfactura', 'PdfController@pdf_comprasfactura');
    Route::get('/rpt_comprasfactura', 'PdfController@rpt_comprasfactura');
    Route::get( '/comprasfactura/getJson' , 'ProductoController@getJsonComprasFactura' );
    Route::get( '/rpt_ventasuf' , 'VentaController@rpt_ventasuf');
    Route::get( '/ventasuf/getJson' , 'VentaController@getJsonVentasuf');
    Route::post( '/pdf_ventasuf', 'PdfController@pdf_ventasuf');

});

Route::group(array('middleware' => 'acl' , 'is' => 'superadmin|consulta|consulta_central|administrator' ), function()
{
    Route::get('/rpt_salida', 'ProductoController@rpt_salidas');
    Route::get('/rpt_ingreso', 'ProductoController@rpt_ingresos');
    Route::post('/pdf_salida', 'PdfController@pdf_salidas');
    Route::post('/pdf_ingreso', 'PdfController@pdf_ingresos');
    Route::get('/existencia/getJson', 'ProductoController@getJsonExistencia');
    Route::get('/ingreso/getJson', 'ProductoController@getJsonIngreso');
    Route::get('/salida/getJson', 'ProductoController@getJsonSalida');
    Route::get( '/getSaldo' , 'CuentaxCobrarController@getSaldo');
    Route::get('/pdf_existenciaprod', 'PdfController@pdf_existenciaprod');
});

Route::group(array('middleware' => 'acl' , 'is' => 'superadmin|administrator|cajero|consulta' ), function()
{
    /* ========== RUTAS PARA LA GESTIÓN DE VENTAS =========== */
    Route::get( '/ventas' , 'VentaController@index');
    Route::get( '/venta/getJson' , 'VentaController@getJson');
    Route::get( '/venta/new' , 'VentaController@create');
    Route::post( '/venta/new' , 'VentaController@addDetalle');
    Route::get('/venta/get/', 'ProductoController@getInfo');
    Route::get('/venta/getProductos', 'ProductoController@getProductos');
    Route::get('/venta/getpartida/', 'ProductoController@getInfoPartida');
    Route::get( '/venta/save/' , 'VentaController@save');
    Route::post( '/venta-detalle/{venta_maestro}' , 'VentaController@saveDetalle');
    Route::delete( '/venta/destroy/{venta_maestro}' , 'VentaController@destroy');
    Route::get('/existencia/getJson', 'ProductoController@getJsonExistencia');
    Route::get('/pdf_ccdetalle', 'PdfController@pdf_ccdetalle');
    Route::get('/pdf_ccresumen', 'PdfController@pdf_ccresumen');
    Route::post('/cortecaja', 'VentaController@makeCorte');
    Route::get('/tipoventa/{venta_maestro}', 'VentaController@getTipoVenta');
    Route::get('/ventadetalle/{venta_maestro}', 'VentaController@show');
    Route::get('/ventaimprime/{venta_maestro}', 'PdfController@ticketventa');
    Route::patch('/venta/{venta_maestro}/update' , 'VentaController@update');
    Route::patch('/venta/update-total/{venta_maestro}/' , 'VentaController@updateTotal');
    Route::get('/ventadetalle/{venta_maestro}/getJson' , 'VentaController@getJsonDetalle');
    Route::delete('/ventadetalle/destroy/{venta_detalle}', 'VentaController@destroyDetalle');
    Route::delete('/ventadetalle2/destroy/{venta_detalle}/{movimiento_producto}', 'VentaController@destroyDetalle2');

    Route::get('/cuentaxcobrar' , 'CuentaxCobrarController@index');
    Route::get('/cuentaxcobrar/getJson' , 'CuentaxCobrarController@getJson');
    Route::get('/cuentaxcobrar/new' , 'CuentaxCobrarController@create');
    Route::post('/cuentaxcobrar/new' , 'CuentaxCobrarController@addDetalle');
    Route::get('/cuentaxcobrar/save/' , 'CuentaxCobrarController@save');
    Route::post('/cuentaxcobrar-detalle/{ctax_cobrarmaestro}' , 'CuentaxCobrarController@saveDetalle');
    Route::delete('/cuentaxcobrar/destroy/{ctax_cobrarmaestro}' , 'CuentaxCobrarController@destroy');
    Route::get('/cuentaxcobrardetalle/{ctax_cobrarmaestro}', 'CuentaxCobrarController@show');
    Route::get('/cuentaxcobrardetalle/{ctax_cobrarmaestro}/getJson' , 'CuentaxCobrarController@getJsonDetalle');
    Route::delete('/cuentaxcobrardetalle/destroy/{ctax_cobrar_detalle}' , 'CuentaxCobrarController@destroyDetalle');
    Route::patch('/cuentaxcobrar/{empleado}/update' , 'CuentaxCobrarController@updateSaldo');
});

});
