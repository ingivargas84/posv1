<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use View;
use App\Producto;
use App\VentaDetalle;
use App\VentaMaestro;
use App\PartidaMaestro;
use App\PartidaAjuste;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;


class PdfController extends Controller
{
     public function ticketventa(VentaMaestro $venta_maestro) 
    {
        $ventamaestro = VentaMaestro::where("id","=",$venta_maestro->id)->get();
        $ventadetalle = VentaDetalle::where("venta_id","=",$venta_maestro->id)->get();
        $user = Auth::user()->name;
        $today = Carbon::now();
        $vendedor = User::where("id","=",$venta_maestro->user_id)->get();
        
        $view =  \View::make('pdf.pdf_ticketventa', compact('ventamaestro', 'ventadetalle', 'user', 'today', 'vendedor'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('ticket', array("Attachment" => 0));
    }
    
    
    public function pdf_ganancia(Request $request) 
    {
        $data = $request->all();
        $fecha_inicio = $data["fecha_inicio"];
        $fecha_final = $data["fecha_final"];
        $data = $this->getDataganancia($fecha_inicio, $fecha_final);
        $user = Auth::user()->name;
        $today = Carbon::now();

        /*$query = " SELECT  SUM(((VD.cantidad)*PR.precio_venta)-((VD.cantidad)*PR.precio_compra)) AS TotalGanancia FROM productos PR INNER JOIN ventas_detalle VD ON PR.id=VD.producto_id WHERE PR.tienda_id = 1 and ((DATE_FORMAT(VD.created_at, '%d-%m-%Y')) between '".$fecha_inicio."'  and '".$fecha_final."') ";

        $total = DB::select($query);*/


        Excel::create('Ganancias por Fecha y Productos', function($excel) use ($fecha_inicio, $fecha_final) {
            $excel->sheet('Ganancias', function($sheet) use ($fecha_inicio, $fecha_final) {

                $ganancias = $this->getDataganancia($fecha_inicio, $fecha_final);
                $json  = json_encode($ganancias);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);

            });
            
        })->export('xls');
    }

    public function getDataganancia($fecha_inicio, $fecha_final) 
    {
        /*$query = "SELECT productos.id as Codigo, productos.codigobarra, productos.prod_nombre, SUM(ventas_detalle.cantidad) as cantidad_vendida, ventas_detalle.precio_compra, (SUM(ventas_detalle.cantidad)*ventas_detalle.precio_compra) as total_costo, ventas_detalle.precio_venta, (SUM(ventas_detalle.cantidad)*ventas_detalle.precio_venta) as total_venta, ((SUM(ventas_detalle.cantidad)*ventas_detalle.precio_venta) - (SUM(ventas_detalle.cantidad)*ventas_detalle.precio_compra)) as ganancia FROM ventas_detalle INNER JOIN productos ON productos.id=ventas_detalle.producto_id WHERE ((DATE_FORMAT(ventas_detalle.created_at, '%d-%m-%Y')) between '".$fecha_inicio."'  and '".$fecha_final."') GROUP BY productos.id, productos.codigobarra, ventas_detalle.precio_compra "; */

        $query = "SELECT PR.id, PR.codigobarra AS Codigo_Barra, 
        PR.prod_nombre AS Producto,  
        SUM(VD.cantidad) AS Cantidad_Vendida, 
        VD.precio_compra AS Precio_Compra, VD.precio_venta AS Precio_Venta,
        ((SUM(VD.cantidad)) * VD.precio_compra) AS Costo, ((SUM(VD.cantidad))*VD.precio_venta) AS Venta,
        (((SUM(VD.cantidad))*VD.precio_venta)  - ((SUM(VD.cantidad))*VD.precio_compra)) AS Ganancia
        FROM ventas_maestro VM 
        INNER JOIN ventas_detalle VD ON VD.venta_id=VM.id 
        INNER JOIN productos PR ON VD.producto_id=PR.id 
        WHERE CAST(VD.created_at as date) BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'
        GROUP BY PR.codigobarra, PR.prod_nombre, VD.precio_compra, VD.precio_venta ";

        $rpt_ganancia = DB::select($query);
        return $rpt_ganancia;
    }

    public function pdf_ajustes(Request $request) 
    {
        $data = $request->all();
        $nopartida = $data["cod_partida"];
        $data = $this->getDataPartida($nopartida);
        $today = Carbon::now();

        Excel::create('Partida de Ajuste', function($excel) use ($nopartida) {
            $excel->sheet('Partidas', function($sheet) use ($nopartida) {
                $partidas = $this->getDataPartida($nopartida);
                $json  = json_encode($partidas);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);
            });
        })->export('xls');
    }

    public function getDataPartida($nopartida) 
    {
        $query = "SELECT productos.codigobarra, productos.prod_nombre, partidas_ajustes.cantidad_ajuste, partidas_ajustes.precio_costo, partidas_ajustes.ingreso as ingreso, partidas_ajustes.salida as salida, partidas_ajustes.ingreso-partidas_ajustes.salida as diferencia FROM partidas_ajustes INNER JOIN productos ON partidas_ajustes.producto_id=productos.id WHERE partida_maestro_id = '".$nopartida."'";
        $rpt_partida = DB::select($query);
        return $rpt_partida;
    }


    public function pdf_existencia() 
    {
        $data = $this->getDataexistencia();
        $user = Auth::user()->name;
        $today = Carbon::now();
        /*$query = "SELECT SUM(precio_compra*existencias) AS Total
        FROM productos 
        WHERE tienda_id=1";
        $total = DB::select($query);*/

        Excel::create('Existencia de Productos', function($excel) {
            $excel->sheet('Productos', function($sheet) {

                $products = $this->getDataexistencia();
                $json  = json_encode($products);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);

            });
            
        })->export('xls');
    }


    public function getDataexistencia() 
    {
        $query = "SELECT productos.id AS Codigo, productos.codigobarra, productos.prod_nombre, IF(movimientos_productos.precio_compra IS NULL,0,ROUND(movimientos_productos.precio_compra,4)) AS precio_compra, IF(SUM(movimientos_productos.existencias) IS NULL,0,SUM(movimientos_productos.existencias)) AS existencias, IF(SUM(movimientos_productos.existencias) IS NULL,0,ROUND(SUM(movimientos_productos.existencias) * movimientos_productos.precio_compra,4)) AS total_neto FROM productos  LEFT JOIN movimientos_productos ON productos.id=movimientos_productos.producto_id WHERE productos.tienda_id=1 AND productos.edo_producto_id=1 GROUP BY productos.id, productos.codigobarra, movimientos_productos.precio_compra ";

        $rpt_existencia = DB::select($query);
        return $rpt_existencia;
    }


    public function pdf_existenciaprod() 
    {
        $data = $this->getDataexistenciaprod();
        $user = Auth::user()->name;
        $today = Carbon::now();

        Excel::create('Existencias de Productos', function($excel) {
            $excel->sheet('Productos', function($sheet) {

                $products = $this->getDataexistenciaprod();
                $json  = json_encode($products);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);

            });
        })->export('xls');
    }


    public function getDataexistenciaprod() 
    {
        $query = "SELECT PR.id, PR.codigobarra, PR.prod_nombre, 
        if(Sum(MP.existencias) is null,0,Sum(MP.existencias)) as existencias 
            FROM productos PR 
        LEFT JOIN movimientos_productos MP on PR.id=MP.producto_id 
        WHERE PR.tienda_id=1 AND PR.edo_producto_id = 1 
        GROUP BY PR.id
        ORDER BY PR.id, PR.codigobarra ";

        $rpt_existenciaprods = DB::select($query);
        return $rpt_existenciaprods;
    }


    public function pdf_salidas(Request $request) 
    {
        $data = $request->all();
        $fecha_inicio = $data["fecha_inicio"];
        $fecha_final = $data["fecha_final"];

        $query = "SELECT SUM(PR.precio_compra*SP.cantidad_salida) AS Total_Neto FROM productos PR INNER JOIN salidas_productos SP ON SP.producto_id=PR.id INNER JOIN tipos_salida TS ON TS.id=SP.tipo_salida_id WHERE Date_Format(SP.fecha_salida, '%d-%m-%Y') between '".$fecha_inicio."'  and '".$fecha_final."'";
        $total = DB::select($query);

        $data = $this->getDatasalida($fecha_inicio, $fecha_final);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_salidas', compact('data', 'user', 'today', 'total', 'fecha_inicio', 'fecha_final'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('salida', array("Attachment" => 0));
    }


    public function getDatasalida($fecha_inicio, $fecha_final) 
    {
        $query = "SELECT DATE(SP.fecha_salida) as Fecha_Salida, PR.codigobarra as Codigo, PR.prod_nombre as Producto, TS.tipo_salida as Tipo_Salida, SUM(SP.cantidad_salida) as Cantidad, PR.precio_compra AS PrecioCompra, (PR.precio_compra*SUM(SP.cantidad_salida)) AS Total_Neto FROM productos PR INNER JOIN salidas_productos SP ON SP.producto_id=PR.id INNER JOIN tipos_salida TS ON TS.id=SP.tipo_salida_id WHERE Date_Format(SP.fecha_salida, '%d-%m-%Y') between '".$fecha_inicio."'  and '".$fecha_final."' GROUP BY SP.fecha_salida, PR.id, PR.prod_nombre, TS.tipo_salida ";
        $rpt_salida = DB::select($query);
        return $rpt_salida;
    }


    public function pdf_ingresos(Request $request) 
    {
        $data = $request->all();
        $fecha_inicio = $data["fecha_inicio"];
        $fecha_final = $data["fecha_final"];
        
        $query = "SELECT SUM(ID.existencias * ID.precio_compra) AS Total_Neto 
        FROM ingresos_detalle ID
        INNER JOIN productos PR ON PR.id=ID.producto_id 
        WHERE Date(ID.created_at) <> '2016-06-26' 
        AND CAST(ID.fecha_ingreso as date) BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'";
        $total = DB::select($query);

        $data = $this->getDataingreso($fecha_inicio, $fecha_final);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_ingresos', compact('data', 'user', 'today', 'total', 'fecha_inicio', 'fecha_final'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('ingreso', array("Attachment" => 0));
    }


    public function getDataingreso($fecha_inicio, $fecha_final) 
    {
        $query = "SELECT DATE(ID.fecha_ingreso) AS Fecha_Ingreso, PR.id AS Codigo, PR.codigobarra, 
        PR.prod_nombre AS Producto, ID.existencias AS Cantidad, 
        ID.precio_compra AS Precio_Compra, 
        (ID.existencias * ID.precio_compra) AS Total_Neto 
        FROM ingresos_detalle ID
        INNER JOIN productos PR ON PR.id=ID.producto_id 
        WHERE Date(ID.created_at) <> '2016-06-26' 
        AND CAST(ID.fecha_ingreso as date) BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'
        GROUP BY ID.fecha_ingreso, PR.id, PR.codigobarra, ID.precio_compra
        ORDER BY ID.fecha_ingreso ASC";
        $rpt_ingreso = DB::select($query);
        return $rpt_ingreso;
    }

    public function pdf_comprasfactura(Request $request) 
    {
        $data = $request->all();
        $fecha_inicio = $data["fecha_inicio"];
        $fecha_final = $data["fecha_final"];

        $tot = "SELECT TRUNCATE(SUM(IM.total_factura),2) as Total 
        FROM ingresos_maestro IM 
        INNER JOIN proveedores PR ON PR.id=IM.proveedor_id 
        WHERE IM.edo_ingreso_id = 1 
        AND CAST(IM.fecha_factura as date) BETWEEN '".$fecha_inicio."' AND '".$fecha_final."'";
        $total = DB::select($tot);

        $data = $this->getDataComprasFactura($fecha_inicio, $fecha_final);
        $user = Auth::user()->name;
        $today = Carbon::now();
        $view =  \View::make('pdf.pdf_comprasfactura', compact('data', 'user', 'today', 'total', 'fecha_inicio', 'fecha_final'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('comprasfactura', array("Attachment" => 0));
    }


    public function getDataComprasFactura($fecha_inicio, $fecha_final)
    {
        $query = "SELECT IM.serie_factura, IM.num_factura, 
        DATE(IM.fecha_factura) AS fecha_factura, PR.nombre_comercial, 
        TRUNCATE(IM.total_factura,2) AS total 
        FROM ingresos_maestro IM
        INNER JOIN proveedores PR ON PR.id=IM.proveedor_id 
        WHERE IM.edo_ingreso_id = 1 
        AND CAST(IM.fecha_factura as date) BETWEEN '".$fecha_inicio."' AND '".$fecha_final."' 
        ORDER BY IM.fecha_factura ASC";
        $rpt_comprasfactura = DB::select($query);
        return $rpt_comprasfactura;
    }

    public function pdf_ccdetalle() 
    {
        $data = $this->getDataCCdetalle();
        $user = Auth::user()->name;
        $today = Carbon::now();

        $efec = "SELECT SUM(VD.subtotal) AS efectivo FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_venta_id=1";
        $efectivo1 = DB::select($efec);

        $tar = "SELECT SUM(VD.subtotal) AS tarjeta FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_venta_id=2";
        $tarjeta1 = DB::select($tar);        

        $sub1 = "SELECT SUM(VD.subtotal) AS subtotal1 FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1";
        $subtotal1 = DB::select($sub1);

        $view =  \View::make('pdf.pdf_ccdetalle', compact('data', 'user', 'today', 'tarjeta1','subtotal1','efectivo1'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('ccdetalle', array("Attachment" => 0));

    }

    public static function getDataCCdetalle() 
    {
        $query = "SELECT TV.tipo_venta AS Tipo_Venta, PR.id, PR.codigobarra AS Codigo_Barra, 
        PR.prod_nombre AS Producto, 
        IF((SELECT sum(existencias) FROM movimientos_productos WHERE producto_id = PR.id) is null,0,
        (SELECT sum(existencias) FROM movimientos_productos WHERE producto_id = PR.id)) as Existencias, 
        SUM(VD.cantidad) AS Cantidad_Vendida, VD.precio_venta AS Precio_Venta, 
        SUM(VD.cantidad)*VD.precio_venta AS Venta 
        FROM ventas_maestro VM 
        INNER JOIN tipo_ventas TV ON VM.tipo_venta_id = TV.id 
        INNER JOIN ventas_detalle VD ON VD.venta_id=VM.id 
        INNER JOIN productos PR ON VD.producto_id=PR.id 
        WHERE VM.edo_venta_id = 1 
        GROUP BY TV.tipo_venta, PR.codigobarra, PR.prod_nombre, VD.precio_venta";
        $rpt_ccdetalle = DB::select($query);
        return $rpt_ccdetalle;
    }

    public function pdf_ccresumen() 
    {
        $data = $this->getDataCCresumen();
        $user = Auth::user()->name;
        $today = Carbon::now();

        $efec = "SELECT SUM(VD.subtotal) AS efectivo FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_venta_id=1";
        $efectivo = DB::select($efec);

        $tar = "SELECT SUM(VD.subtotal) AS tarjeta FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_venta_id=2";
        $tarjeta = DB::select($tar);        

        $sub1 = "SELECT SUM(VD.subtotal) AS subtotal1 FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_venta_id=1";
        $subtotal1 = DB::select($sub1); 

        $sub11 = "SELECT SUM(VD.subtotal) + 250 AS subtotal11 FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1";
        $subtotal11 = DB::select($sub11); 

        $sub12 = "SELECT (SUM(VD.subtotal) + 250) - (SELECT SUM(VD.subtotal) AS tarjeta FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_venta_id=2) AS subtotal12 FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1";
        $subtotal12 = DB::select($sub12); 

        $sub2 = "SELECT SUM(VD.subtotal) - 250 AS subtotal2 FROM ventas_maestro VM INNER JOIN ventas_detalle VD ON VM.id = VD.venta_id WHERE VM.edo_venta_id = 1 AND VM.tipo_venta_id=1";
        $subtotal2 = DB::select($sub2); 

        $view =  \View::make('pdf.pdf_ccresumen', compact('data', 'user', 'today', 'efectivo', 'tarjeta', 'subtotal1', 'subtotal2', 'subtotal11', 'subtotal12'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('ccresumen', array("Attachment" => 0));
    }

    public static function getDataCCresumen() 
    {
        $query = "SELECT (SELECT SUM(VM.total_venta) FROM ventas_maestro VM WHERE VM.edo_venta_id = 1 AND VM.tipo_venta_id=1) AS Efectivo, (SELECT SUM(VM.total_venta) FROM ventas_maestro VM WHERE VM.edo_venta_id = 1 AND VM.tipo_venta_id=2) AS Tarjeta, (SELECT SUM(VM.total_venta) FROM ventas_maestro VM WHERE VM.edo_venta_id = 1) AS Subtotal1, (SELECT SUM(VM.total_venta) -200 FROM ventas_maestro VM WHERE VM.edo_venta_id = 1) AS Subtotal2 FROM ventas_maestro VM WHERE VM.edo_venta_id = 1";
        $rpt_ccresumen = DB::select($query);
        return $rpt_ccresumen;
    }


    public function pdf_cuentasxcobrar() 
    {
        $data = $this->getDataCuentasxCobrar();
        $user = Auth::user()->name;
        $today = Carbon::now();

        $tot = "SELECT SUM(ctsx_cobrar_maestro.total_x_cobrar) as total FROM ctsx_cobrar_maestro WHERE ctsx_cobrar_maestro.edo_ctsxcobrar_id = 1";
        $total = DB::select($tot);

        $view =  \View::make('pdf.pdf_cuentasxcobrar', compact('data', 'user', 'today', 'total'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('cuentasxcobrar', array("Attachment" => 0));
    }

    public function getDataCuentasxCobrar() 
    {
        $query = 'SELECT ctsx_cobrar_maestro.fecha as fecha, TRUNCATE(ctsx_cobrar_maestro.total_x_cobrar,4) as total_venta, ctsx_cobrar_maestro.id, CONCAT(empleados.emp_nombres, " ", empleados.emp_apellidos) as nombrec, 
        users.name as name,  estados_ctsx_cobrar.edo_ctsx_cobrar FROM ctsx_cobrar_maestro INNER JOIN empleados ON ctsx_cobrar_maestro.empleado_id=empleados.id INNER JOIN users ON users.id=ctsx_cobrar_maestro.user_id INNER JOIN estados_ctsx_cobrar ON ctsx_cobrar_maestro.edo_ctsxcobrar_id=estados_ctsx_cobrar.id WHERE ctsx_cobrar_maestro.edo_ctsxcobrar_id = 1';
        $rpt_ccresumen = DB::select($query);
        return $rpt_ccresumen;
    }


    public function rpt_comprasfactura()
    {
        $query = 'SELECT ingresos_maestro.id, ingresos_maestro.serie_factura, ingresos_maestro.num_factura, DATE_FORMAT(ingresos_maestro.fecha_factura, "%d-%m-%Y") as fecha_factura, proveedores.nombre_comercial, TRUNCATE(ingresos_maestro.total_factura,2) as total FROM ingresos_maestro INNER JOIN proveedores ON proveedores.id=ingresos_maestro.proveedor_id ';
        $rpt_comprasfactura = DB::select($query);
        return View::make('reportes.comprasfactura', compact('rpt_comprasfactura'));
    }


    public function pdf_ventasuf(Request $request) 
    {
        $datas = $request->all();
        $fec = $datas["fecha_inicio"];
        $us = $datas["userslst"];

        // $data = $this->getDataVentasuf($fec,$us);
        // $user = Auth::user()->name;
        // $today = Carbon::now();
        
        Excel::create('Ventas por Fechas y Usuario', function($excel) use ($fec, $us) {
            $excel->sheet('Ventas', function($sheet) use ($fec, $us) {

                $ventas = $this->getDataVentasuf($fec,$us);
                $json  = json_encode($ventas);
                $body = json_decode($json, true);
                $sheet->fromArray($body, null, 'A1', true);

            });
            
        })->export('xls');
    }


    public function getDataVentasuf($fec, $us) 
    {
        $query = "SELECT vm.id as id, vm.created_at as fec, tv.tipo_venta as tventa, vm.total_venta as tot, us.name as user, ev.edo_venta as estado
        FROM ventas_maestro vm 
        INNER JOIN ventas_detalle vd ON vd.venta_id=vm.id
        INNEr JOIN tipo_ventas tv ON tv.id=vm.tipo_venta_id
        INNER JOIN estado_ventas ev ON ev.id=vm.edo_venta_id
        INNER JOIN users us ON us.id=vm.user_id 
        WHERE CAST(vm.created_at AS date) = '".$fec."' AND vm.user_id = ".$us." GROUP BY vm.id, vm.created_at, tv.tipo_venta, vm.total_venta, us.name, ev.edo_venta ";

        $rpt_ventasufs = DB::select($query);
        return $rpt_ventasufs;
    }
}
