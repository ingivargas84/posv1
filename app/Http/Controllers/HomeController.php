<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Bitacora;
use App\IngresoMaestro;
use App\VentaMaestro;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = date("Y-m-d");
       
        $compras = IngresoMaestro::select(
            DB::raw('SUM(total_factura) as total')
        )->where([
            ['edo_ingreso_id','=',1],
            ['fecha_factura','=',$date]
        ])->get();

        $query_ventas = "SELECT SUM(total_venta) as total FROM ventas_maestro WHERE edo_venta_id in (1,4) AND DATE(created_at) = '" . $date . "'";
        $ventas = DB::select($query_ventas); 

        return view('home', compact('compras', 'ventas'));
    }


    public function getSalesData() {
        $month = date('m');

        $query_ventas_mes = "SELECT DATE(created_at) as fecha, SUM(total_venta) as amount 
        FROM ventas_maestro 
        WHERE edo_venta_id in (1,4) AND MONTH(created_at) = " . $month . "
        GROUP BY fecha
        ORDER BY fecha";

        $data = DB::select($query_ventas_mes);

        return Response::json($data);
    }

    public function getPurchaseData() {
        $month = date('m');

        $query_compras_mes = "SELECT fecha_factura as fecha, SUM(total_factura) as amount 
        FROM ingresos_maestro 
        WHERE edo_ingreso_id = 1 AND MONTH(fecha_factura) = " . $month . "
        GROUP BY fecha
        ORDER BY fecha";

        $data = DB::select($query_compras_mes);

        return Response::json($data);
    }

    public function construccion()
    {
        return view('construccion');
    }


    public static function bitacora($action)
    {
    $datos['user_id'] = Auth::user()->id;
    $datos['accion'] = $action;
    $data = Bitacora::create($datos);
    return $data;

    }
}
