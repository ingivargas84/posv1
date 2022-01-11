<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use View;
use App\CtaxCobrarDetalle;
use App\CtaxCobrarmaestro;
use App\Producto;
use App\User;
use App\Empleado;
use App\Tienda;
use App\Estadoctaxcobrar;
use App\MovimientoCtaxCobrar;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CuentaxCobrarController extends Controller
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
        $empleados = Empleado::all();
        return view("cuentaxcobrar.index", compact("empleados"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $back = "cuentaxcobrar";
        $today = Carbon::now();
        $empleados = Empleado::all();
        return view("cuentaxcobrar.create" , compact( "back", "empleados", "today"));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function save(Request $request)
    {
        $data = $request->all();
        $data["user_id"] = Auth::user()->id;
        $data["edo_ctsxcobrar_id"] = 1;
        $data["tienda_id"] = 1;
        $data["fecha"] = Carbon::now();
        $maestro = Ctaxcobrarmaestro::create($data);
        $empleado = $data["empleado_id"];
        $query = "Select id, saldo 
        from movimientos_ctaxcobrar 
        where empleado_id=".$empleado."
        order by id Desc LIMIT 1";
        $result = DB::select($query);
        if (count($result) == 0)
        {
            $result2 = 0;
        }
        else 
        {
            $result2 = $result[0]->saldo;
        }

        $saldo2 = $result2 + $data["total_x_cobrar"];
        $movimiento["fecha_movimiento"] = Carbon::now();
        $movimiento["user_id"] = Auth::user()->id;
        $movimiento["empleado_id"] = $data["empleado_id"];
        $movimiento["tipo_movimiento_id"] = 1;
        $movimiento["monto"] = $data["total_x_cobrar"];
        $movimiento["saldo"] = $saldo2;
        $movimiento2 = MovimientoCtaxCobrar::create($movimiento);
        return $maestro;
    }

    public function saveDetalle(Request $request, Ctaxcobrarmaestro $ctax_cobrarmaestro)
    {
        $statsArray = $request->all();
        foreach($statsArray as $stat) {
            $producto = Producto::where('id', $stat["producto_id"])
            ->get()->first();
            $detalle["precio_compra"] = $producto->precio_compra;
            $stat["subtotal"] = $stat["subtotal"];
            $stat["precio_compra"] = $detalle["precio_compra"];
            $ctax_cobrarmaestro->ctaxcobrardetalle()->create($stat);
            $existencias = $producto->existencias;
            $cantidad = $stat["cantidad"];
            $newExistencias = $existencias - $cantidad;
            $updateExistencia = Producto::where('id', $stat["producto_id"])
            ->update(['existencias' => $newExistencias]);
        }
        return Response::json(['result' => 'ok']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ctaxcobrarmaestro $ctax_cobrarmaestro)
    {
        return view('cuentaxcobrar.show')->with('ctax_cobrarmaestro', $ctax_cobrarmaestro);
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
    public function update(VentaMaestro $venta_maestro, Request $request)
    {
        $data = $request->all();
        $venta_maestro->tipo_venta_id = $data["tipo_venta_id"];
        $venta_maestro->save();
        return $venta_maestro;
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ctaxcobrarmaestro $ctax_cobrarmaestro, Request $request)
    {

        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $detalles = CtaxCobrarDetalle::where('ctsx_cobrar_id', $ctax_cobrarmaestro->id)
            ->get();
            foreach($detalles as $detalle) 
            {
                $producto = Producto::where('id', $detalle["producto_id"])
                ->get()->first();
                $existencias = $producto->existencias;
                $cantidad = $detalle["cantidad"];
                $newExistencias = $existencias + $cantidad;
                $updateExistencia = Producto::where('id', $detalle["producto_id"])
                ->update(['existencias' => $newExistencias]);
            }
            $ctax_cobrarmaestro->delete();
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }



    }

    public function destroyDetalle(CtaxCobrarDetalle $ctax_cobrar_detalle, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {

            $producto = Producto::where('id', $ctax_cobrar_detalle->producto_id)
            ->get()->first();
            $existencias = $producto->existencias;
            $cantidad = $ctax_cobrar_detalle->cantidad;
            $newExistencias = $existencias + $cantidad;
            $updateExistencia = Producto::where('id', $ctax_cobrar_detalle->producto_id)
            ->update(['existencias' => $newExistencias]);

            $ventamaestro = Ctaxcobrarmaestro::where('id', $ctax_cobrar_detalle->ctsx_cobrar_id)
            ->get()->first();
            $total = $ventamaestro->total_x_cobrar;
            $totalresta = $ctax_cobrar_detalle->subtotal;
            $newTotal = $total - $totalresta;
            $updateTotal = Ctaxcobrarmaestro::where('id', $ctax_cobrar_detalle->ctsx_cobrar_id)
            ->update(['total_x_cobrar' => $newTotal]);

            
            $ctax_cobrar_detalle->delete();
        }
        else {
            $response["password_delete"] = "La contraseña no coincide";
            return Response::json( $response  , 422 );
        }



    }


    public function getTipoVenta( VentaMaestro $venta_maestro )
    {
        $result = VentaMaestro::where( "id" , "=" , $venta_maestro->id )
        ->get()
        ->first();
        return Response::json( $result);
    }

    public function makeCorte ()
    {
        $today = Carbon::now();
        $query = "update ventas_maestro set edo_venta_id=4 where edo_venta_id=1";
        $result = DB::select($query);

        return view("home");


    }

    public function getJson(Request $params)
    {
        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("ctsx_cobrar_maestro.id", "ctsx_cobrar_maestro.total_x_cobrar", "empleados.name", "ctsx_cobrar_maestro.edo_venta", "users.name", "estados_ctsx_cobrar.edo_ctsx_cobrar");

        // Initialize query (get all)


        $api_logsQueriable = DB::table('ctsx_cobrar_maestro');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'Select TRUNCATE(total_x_cobrar,4) as total_venta, ctsx_cobrar_maestro.id, 
        CONCAT(empleados.emp_nombres, " ", empleados.emp_apellidos) as nombrec, 
        users.name as name,  estados_ctsx_cobrar.edo_ctsx_cobrar from ctsx_cobrar_maestro inner join empleados on ctsx_cobrar_maestro.empleado_id=empleados.id inner join users on users.id=ctsx_cobrar_maestro.user_id inner join estados_ctsx_cobrar on ctsx_cobrar_maestro.edo_ctsxcobrar_id=estados_ctsx_cobrar.id ';

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

    public function getJsonDetalle(Request $params, $detalle)
    {
        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("id", "prod_nombre", "cantidad", "subtotal");

        // Initialize query (get all)


        $api_logsQueriable = DB::table('ctsx_cobrar_detalle');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'Select TRUNCATE(subtotal,4) as subtotal, ctsx_cobrar_detalle.id, cantidad, prod_nombre from ctsx_cobrar_detalle  inner join productos on ctsx_cobrar_detalle.producto_id=productos.id where ctsx_cobrar_id='.$detalle.' ';

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


    public function rpt_cuentasxcobrar()
    {
        $query = 'SELECT TRUNCATE(ctsx_cobrar_maestro.total_x_cobrar,4) as total_venta, ctsx_cobrar_maestro.id, CONCAT(empleados.emp_nombres, " ", empleados.emp_apellidos) as nombrec, 
        users.name as name,  estados_ctsx_cobrar.edo_ctsx_cobrar FROM ctsx_cobrar_maestro INNER JOIN empleados ON ctsx_cobrar_maestro.empleado_id=empleados.id INNER JOIN users ON users.id=ctsx_cobrar_maestro.user_id INNER JOIN estados_ctsx_cobrar ON ctsx_cobrar_maestro.edo_ctsxcobrar_id=estados_ctsx_cobrar.id WHERE ctsx_cobrar_maestro.edo_ctsxcobrar_id = 1  ';

        $rpt_cuentas = DB::select($query);
        return View::make('reportes.cuentasxcobrar', compact('rpt_cuentas'));
    }

    public function getSaldo(Request $request)
    {
        $empleado = $request["empleado"];
        $query = "Select id, saldo 
        from movimientos_ctaxcobrar 
        where empleado_id=".$empleado."
        order by id Desc LIMIT 1";
        $result = DB::select($query);
        return Response::json( $result);
    }

    public function updateSaldo (Empleado $empleado, Request $request)
    {
        $data =$request->all();
        $data["tipo_movimiento_id"] = 2;
        $data["user_id"] = Auth::user()->id;
        $data["fecha_movimiento"] = Carbon::now();
        $data["saldo"] = $data["saldo"] - $data["monto"];
        $movimiento2 = MovimientoCtaxCobrar::create($data);
        return Response::json( $movimiento2);
    }



    public function getJsonReporte(Request $params)
    {
        $api_Result = array();
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("ctsx_cobrar_maestro.id", "ctsx_cobrar_maestro.total_x_cobrar", "empleados.name", "ctsx_cobrar_maestro.edo_venta", "users.name", "estados_ctsx_cobrar.edo_ctsx_cobrar");

        // Initialize query (get all)


        $api_logsQueriable = DB::table('ctsx_cobrar_maestro');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT TRUNCATE(ctsx_cobrar_maestro.total_x_cobrar,4) as total_venta, ctsx_cobrar_maestro.id, CONCAT(empleados.emp_nombres, " ", empleados.emp_apellidos) as nombrec, 
        users.name as name,  estados_ctsx_cobrar.edo_ctsx_cobrar FROM ctsx_cobrar_maestro INNER JOIN empleados ON ctsx_cobrar_maestro.empleado_id=empleados.id INNER JOIN users ON users.id=ctsx_cobrar_maestro.user_id INNER JOIN estados_ctsx_cobrar ON ctsx_cobrar_maestro.edo_ctsxcobrar_id=estados_ctsx_cobrar.id WHERE ctsx_cobrar_maestro.edo_ctsxcobrar_id = 1 ';

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
