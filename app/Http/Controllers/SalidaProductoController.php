<?php

namespace App\Http\Controllers;

use App\SalidaProducto;
use App\User;
use App\Producto;
use App\TipoSalida;
use View;
Use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Kodeine\Acl\Models\Eloquent\Role;
use Kodeine\Acl\Models\Eloquent\Permission;
use Carbon\Carbon;

class SalidaProductoController extends Controller
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
        $tipo_salidas = TipoSalida::all();
        return view("salidaproducto.index", compact("tipo_salidas"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $back = "salidaproducto";
       $tipo_salidas = TipoSalida::all();
       $productos = Producto::all();
       return view("salidaproducto.create" , compact( "back", "tipo_salidas", "productos"));
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['fecha_salida'] = Carbon::createFromFormat('d-m-Y', $data['fecha_salida']);
        $data["user_id"] = Auth::user()->id;
        $salidaproducto = SalidaProducto::create($data);
        $producto = Producto::where('id', $data["producto_id"])
        ->get()->first();
        $existencias = $producto->existencias;
        $cantidad = $data["cantidad_salida"];
        $newExistencias = $existencias - $cantidad;
        $updateExistencia = Producto::where('id', $data["producto_id"])
        ->update(['existencias' => $newExistencias]);
        return Redirect::route('salidaproducto.index');
    }


    public function getName( SalidaProducto $salidaproducto )
    {
        $salidaproducto = SalidaProducto::where( "salidas_productos.id" , "=" , $salidaproducto->id )
        ->select( "salidas_productos.id","salidas_productos.producto_id", "salidas_productos.cantidad_salida" , "salidas_productos.fecha_salida", "salidas_productos.user_id","salidas_productos.tipo_salida_id")
        ->get()
        ->first();
        return Response::json( $salidaproducto);
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

    public function update( SalidaProducto $salidaproducto, Request $request )
    {
        $data = $request->all();
        $salidaproducto->tipo_salida_id = $data["tipo_salida_id"];
        $salidaproducto->save();
        return $salidaproducto;  
    }
/*
    public function update( SalidaProducto $salidaproducto, Request $request )
    {
        if( $request["cantidad_salida"] == "") 
        {
            $response["cantidad_salida"]  = "Cantidad de Salida es requerida";
            return Response::json( $response  , 422 );
        }
        else 
        {
            return Response::json( $this->updateSalidaProducto($salidaproducto , $request->all()));
        }
    }*/

    public function getTipoSalida( SalidaProducto $salida_producto )
    {
        $result = SalidaProducto::where( "id" , "=" , $salida_producto->id )
        ->get()
        ->first();
        return Response::json( $result);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateSalidaProducto( SalidaProducto $salidaproducto , array $data )
    {
        $producto = Producto::where('id', $salidaproducto->producto_id)
        ->get()->first();
        $existencias = $producto->existencias;
        $cantidad = $salidaproducto->cantidad_salida;
        $newExistencias = $existencias + $cantidad;
        $updateExistencia = Producto::where('id', $salidaproducto->producto_id)
        ->update(['existencias' => $newExistencias]);


        $id= $salidaproducto->id;
        $data['fecha_salida'] = Carbon::createFromFormat('d-m-Y', $data['fecha_salida']);
        $salidaproducto->cantidad_salida = $data["cantidad_salida"];
        $salidaproducto->fecha_salida = $data["fecha_salida"];
        $salidaproducto->tipo_salida_id = $data["tipo_salida_id"];
        $salidaproducto->save();

        $producto = Producto::where('id', $salidaproducto->producto_id)
        ->get()->first();
        $existencias = $producto->existencias;
        $cantidad = $data["cantidad_salida"];
        $newExistencias2 = $existencias - $cantidad;
        $updateExistencia = Producto::where('id', $salidaproducto->producto_id)
        ->update(['existencias' => $newExistencias2]);
        return $salidaproducto;
    }


    public function destroy( SalidaProducto $salidaproducto, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contrase単a es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $producto = Producto::where('id', $salidaproducto->producto_id)
            ->get()->first();
            $existencias = $producto->existencias;
            $cantidad = $salidaproducto->cantidad_salida;
            $newExistencias = $existencias + $cantidad;
            $updateExistencia = Producto::where('id', $salidaproducto->producto_id)
            ->update(['existencias' => $newExistencias]);
            $salidaproducto->delete();
            $response["response"] = "El registro ha sido borrado";
            return Response::json( $response );
        }
        else {
            $response["password_delete"] = "La contrase単a no coincide";
            return Response::json( $response  , 422 );
        }
    }

    public function getJson(Request $params)

    {
        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("SP.id","SP.producto_id", "PR.codigobarra", "PR.prod_nombre", "SP.fecha_salida", "SP.cantidad_salida", "TS.tipo_salida");

        // Initialize query (get all)

        $api_logsQueriable = DB::table('salidas_productos');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = "SELECT SP.id, SP.producto_id as codigo, PR.codigobarra,  PR.prod_nombre, DATE_FORMAT(SP.fecha_salida, '%d-%m-%Y') as fecha_salida, SP.cantidad_salida, TS.tipo_salida FROM salidas_productos SP INNER JOIN productos PR ON PR.id=SP.producto_id INNER JOIN tipos_salida TS ON SP.tipo_salida_id=TS.id  ";

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

        $query = $query . $where;

        // Sorting
        $sort = " ORDER BY SP.producto_id ASC ";
        /*foreach ($params->order as $order) {
            if (strlen($sort) == 0) {
                $sort .= ' order by ' . $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
            } else {
                $sort .= ', '. $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
            }
        }*/

        $result = DB::select($query);
        $api_Result['recordsFiltered'] = count($result);

        $filter = " limit ".$params->length." offset ".$params->start."";

        $query .= $sort . $filter;
        
        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }


}
