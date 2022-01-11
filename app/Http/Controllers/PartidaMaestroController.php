<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\PartidaMaestro;
use App\PartidaAjuste;
use App\MovimientoProducto;
use App\TipoAjuste;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PartidaMaestroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $partida_maestro = PartidaMaestro::all();
        return view("partidamaestro.index", compact("partida_maestro"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $today = date("Y/m/d");
        $tipo_ajuste = TipoAjuste::all();
        return view("partidamaestro.create" , compact( "tipo_ajuste", "today"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartidaMaestro $partida_maestro, Request $request)
    {

        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $detalles = PartidaAjuste::where('partida_maestro_id', $partida_maestro->id)
            ->get();
            foreach($detalles as $detalle) 
            {
                $producto = MovimientoProducto::where('id', $detalle->movimiento_producto_id)
                ->get()->first();
                $existencias = $producto->existencias;
                $cantidad = $detalle->cantidad_ajuste;


                if ($detalle->ingreso != 0)
                {
                    $newExistencias = $existencias - $cantidad;
                    $updateExistencia = MovimientoProducto::where('id', $detalle->movimiento_producto_id)
                    ->update(['existencias' => $newExistencias]);
                }
                else 
                {
                    $newExistencias = $existencias + $cantidad;
                    $updateExistencia = MovimientoProducto::where('id', $detalle->movimiento_producto_id)
                    ->update(['existencias' => $newExistencias]);           
                }
                $detalle->delete();
            }
            $partida_maestro->delete();
            $response["response"] = "El registro ha sido borrado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }
    }
    

    public function getJson(Request $params)
    {
        $api_Result = array();

        $columnsMapping = array("id","fecha_partida","total_ingreso","total_salida","saldo");

        $api_logsQueriable = DB::table('partidas_maestro');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT * FROM partidas_maestro ';

        $where = "";

        if (isset($params->search['value']) && !empty($params->search['value'])){

            foreach ($columnsMapping as $column) {
                if (strlen($where) == 0) {
                    $where .=" and (".$column." like  '%".$params->search['value']."%' ";
                } else {
                    $where .=" or ".$column." like  '%".$params->search['value']."%' ";
                }

            }
            $where .= ') ';
        }
        $condition = "";
        $query = $query . $where . $condition;

        // Sorting
        $sort = "";
        foreach ($params->order as $order) {
            if (strlen($sort) == 0) {
                $sort .= 'order by ' . $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
            } else {
                $sort .= ', '. $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
            }
        }

        $result = DB::select($query);
        $api_Result['recordsFiltered'] = count($result);

        $filter = " limit ".$params->length." offset ".$params->start."";

        $query .= $sort . $filter;

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
