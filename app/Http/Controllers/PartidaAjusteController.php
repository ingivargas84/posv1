<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use View;
use DB;
use App\PartidaAjuste;
use App\PartidaMaestro;
use App\MovimientoProducto;
use App\Producto;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PartidaAjusteController extends Controller
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
        $partida_ajuste = PartidaAjuste::all();
        return view("partidaajuste.index", compact("partida_ajuste"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function rpt_partida()
    {
        $query = "SELECT id, fecha_partida, total_ingreso, total_salida, saldo FROM partidas_maestro ORDER BY id ASC";

        $rpt_ajuste = DB::select($query);
        return View::make('reportes.ajustes', compact('rpt_ajuste'));
    }


    public function partidagetJson(Request $params)
    {
        $api_Result = array();
        
        $columnsMapping = array("id, fecha_partida, total_ingreso, total_salida, saldo");

        $api_logsQueriable = DB::table('partidas_maestro');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT id, fecha_partida, total_ingreso, total_salida, saldo FROM partidas_maestro ';

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
    

    public function save(Request $request)
    {
        $data = $request->all();

        if ($data["tipo_ajuste_id"] == 1) {
            $data["total_ingreso"]=0;
            $data["total_salida"]=0;
        }else{
            $data["total_ingreso"]=0;
            $data["total_salida"]=0;
        }
        $data["fecha_partida"] = date("Y/m/d");
        $data["user_id"] = Auth::user()->id;
        $ajuste = PartidaMaestro::create($data);
        return Response::json( $ajuste );
    }

    public function destroyDetalle2(PartidaAjuste $partida_ajuste, MovimientoProducto $movimiento_producto, Request $request)
    {
        $existencias = $movimiento_producto->existencias;
        $cantidad = $partida_ajuste->cantidad_ajuste;

        if ($partida_ajuste->ingreso != 0)
        {
            $newExistencias = $existencias - $cantidad;
            $updateExistencia = MovimientoProducto::where('id', $movimiento_producto->id)
            ->update(['existencias' => $newExistencias]);

            $partida = PartidaMaestro::where('id', $partida_ajuste->partida_maestro_id)
            ->get()->first();
            $totalI = $partida->total_ingreso - $partida_ajuste->ingreso;
            $partida->total_ingreso =  $totalI;
            $partida->save();
        }
        else 
        {
            $newExistencias = $existencias + $cantidad;
            $updateExistencia = MovimientoProducto::where('id', $movimiento_producto->id)
            ->update(['existencias' => $newExistencias]);  

            $partida = PartidaMaestro::where('id', $partida_ajuste->partida_maestro_id)
            ->get()->first();
            $totalS = $partida->total_salida - $partida_ajuste->salida;
            $partida->total_salida =  $totalS;
            $partida->save();

        }

        $partidaN = PartidaMaestro::where('id', $partida->id)
        ->get()->first();
        $new_total = ($partidaN->total_ingreso - $partidaN->total_salida);
        $updateExistencia = PartidaMaestro::where('id', $partidaN->id)
        ->update(['saldo' => $new_total]);
        $partida_ajuste->delete();
        $response["response"] = "El registro ha sido borrado";
        return Response::json($response);
    }

    public function destroyDetalle(PartidaAjuste $partida_ajuste, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contrase«Ða es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $producto = MovimientoProducto::where('id', $partida_ajuste->movimiento_producto_id)
            ->get()->first();
            $existencias = $producto->existencias;
            $cantidad = $partida_ajuste->cantidad_ajuste;


            if ($partida_ajuste->ingreso != 0)
            {
                $newExistencias = $existencias - $cantidad;
                $updateExistencia = MovimientoProducto::where('id', $partida_ajuste->movimiento_producto_id)->update(['existencias' => $newExistencias]);

                $partida_maestro = PartidaMaestro::where('id', $partida_ajuste->partida_maestro_id)
                ->get()->first();
                $total_ingreso = $partida_maestro->total_ingreso;
                $new_total = $total_ingreso - $partida_ajuste->ingreso;
                $saldo = $partida_maestro->saldo;
                $new_saldo = $saldo - $partida_ajuste->ingreso;
                $updateIngreso = PartidaMaestro::where('id', $partida_ajuste->partida_maestro_id)
                ->update(['total_ingreso' => $new_total]);
                $updateSaldo = PartidaMaestro::where('id', $partida_ajuste->partida_maestro_id)
                ->update(['saldo' => $new_saldo]);

                $partida_ajuste->delete();
            }
            else 
            {
                $newExistencias = $existencias + $cantidad;
                $updateExistencia = MovimientoProducto::where('id', $partida_ajuste->movimiento_producto_id)->update(['existencias' => $newExistencias]);

                $partida_maestro = PartidaMaestro::where('id', $partida_ajuste->partida_maestro_id)
                ->get()->first();
                $total_salida = $partida_maestro->total_salida;
                $new_total = $total_salida - $partida_ajuste->salida;
                $saldo = $partida_maestro->saldo;
                $new_saldo = $saldo + $partida_ajuste->salida;
                $updateIngreso = PartidaMaestro::where('id', $partida_ajuste->partida_maestro_id)
                ->update(['total_salida' => $new_total]);
                $updateSaldo = PartidaMaestro::where('id', $partida_ajuste->partida_maestro_id)
                ->update(['saldo' => $new_saldo]);

                $partida_ajuste->delete();           
            }

        }
        else 
        {
            $response["password_delete"] = "La contrase«Ða no coincide";
            return Response::json( $response  , 422 );
        }
    }


    public function saveDetalle(Request $request, PartidaMaestro $partida_maestro)
    {
        $data2 = $request->all();
        foreach($data2 as $data) {
            $movproducto = MovimientoProducto::where('id', $data["movimiento_id"])
            ->get()->first();
            $data["user_id"] = Auth::user()->id;
            $data["movimiento_producto_id"] = $data["movimiento_id"];
            $ajuste2 = $partida_maestro->partidaajuste()->create($data);

            if ($ajuste2->ingreso != 0) 
            {
                $existencias = $movproducto->existencias;
                $cantidad = $data["cantidad_ajuste"];
                $newExistencias = $existencias + $cantidad;
                $updateExistencia = MovimientoProducto::where('id', $data["movimiento_id"])
                ->update(['existencias' => $newExistencias]);
                $totalI = $partida_maestro->total_ingreso + $data["ingreso"];
                $partida_maestro->total_ingreso =  $totalI;
                $partida_maestro->save();

            }
            else 
            {
                $existencias = $movproducto->existencias;
                $cantidad = $data["cantidad_ajuste"];
                $newExistencias = $existencias - $cantidad;
                $updateExistencia = MovimientoProducto::where('id', $data["movimiento_id"])
                ->update(['existencias' => $newExistencias]);
                $totalS = $partida_maestro->total_salida + $data["salida"];
                $partida_maestro->total_salida =  $totalS;
                $partida_maestro->save();

            }

        }

        $partida = PartidaMaestro::where('id', $partida_maestro->id)
        ->get()->first();
        $new_total = ($partida->total_ingreso - $partida->total_salida);
        $updateExistencia = PartidaMaestro::where('id', $partida->id)
        ->update(['saldo' => $new_total]);
        return $ajuste2;
    }


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PartidaMaestro $partida_maestro, $partidadetalle)
    {
        return view('partidaajuste.show')->with('partidadetalle', $partidadetalle);
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

    public function updateTotal(PartidaMaestro $partida_maestro, Request $request)
    {
        return $partida_maestro;
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getJson(Request $params, $partidadetalle)
    {
        $api_Result = array();
        
        $columnsMapping = array("partidas_ajustes.id", "productos.codigobarra", "productos.prod_nombre", "partidas_ajustes.cantidad_ajuste", "partidas_ajustes.precio_costo", "partidas_ajustes.ingreso", "partidas_ajustes.salida");

        $api_logsQueriable = DB::table('partidas_ajustes');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT partidas_ajustes.id, productos.codigobarra, productos.prod_nombre, partidas_ajustes.cantidad_ajuste, partidas_ajustes.precio_costo, partidas_ajustes.ingreso, partidas_ajustes.salida FROM partidas_ajustes INNER JOIN productos ON partidas_ajustes.producto_id = productos.id where partida_maestro_id ='.$partidadetalle.'  ';

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