<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;
use DB;
use App\Producto;
use App\TipoVenta;
use App\VentaMaestro;
use App\VentaDetalle;
use App\MovimientoProducto;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Mail;

class VentaController extends Controller
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
		$tipo_ventas = TipoVenta::all();
		return view("venta.index", compact("tipo_ventas"));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$back = "producto";
		$today = date("Y/m/d");
		$tipo_ventas = TipoVenta::all();
		return view("venta.create" , compact( "back", "tipo_ventas", "today"));
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
		$data["edo_venta_id"] = 1;
		$maestro = VentaMaestro::create($data);
		return $maestro;
	}

	public function saveDetalle(Request $request, VentaMaestro $venta_maestro)
	{
		$statsArray = $request->all();
		foreach($statsArray as $stat) {
			$producto = MovimientoProducto::where('id', $stat["movimiento_id"])
			->get()->first();
			$stat["precio_compra"] = $stat["precio_compra"];
			$stat["precio_venta"] = $stat["precio_venta"];
			$stat["subtotal"] = $stat["precio_venta"] * $stat["cantidad"];
			$stat["movimiento_producto_id"] = $stat["movimiento_id"];
			$result = $venta_maestro->ventadetalle()->create($stat);
			$total_venta = $venta_maestro->total_venta + $stat["subtotal"];
			$venta_maestro->total_venta = $total_venta;
			$venta_maestro->save();
			$existencias = $producto->existencias;
			$cantidad = $stat["cantidad"];
			$newExistencias = $existencias - $cantidad;
			$updateExistencia = MovimientoProducto::where('id', $stat["movimiento_id"])
			->update(['existencias' => $newExistencias]);
		}
		return Response::json($result);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(VentaMaestro $venta_maestro)
	{
		return view('venta.show')->with('venta_maestro', $venta_maestro);
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
	
	public function updateTotal(VentaMaestro $venta_maestro, Request $request)
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
	public function destroy(VentaMaestro $venta_maestro, Request $request)
	{

		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$detalles = VentaDetalle::where('venta_id', $venta_maestro->id)
			->get();
			foreach($detalles as $detalle) 
			{
				$producto = MovimientoProducto::where('id', $detalle["movimiento_producto_id"])
				->get()->first();
				$existencias = $producto->existencias;
				$cantidad = $detalle->cantidad;
				$newExistencias = $existencias + $cantidad;
				$updateExistencia = MovimientoProducto::where('id', $detalle["movimiento_producto_id"])
				->update(['existencias' => $newExistencias]);
			}
			$venta_maestro->delete();
			$response["response"] = "El registro ha sido borrado";
			return Response::json( $response );
		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}
	}



	public function destroyDetalle(VentaDetalle $venta_detalle, Request $request)
	{

		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$producto = MovimientoProducto::where('id', $venta_detalle->movimiento_producto_id)
			->get()->first();
			$existencias = $producto->existencias;
			$cantidad = $venta_detalle->cantidad;
			$newExistencias = $existencias + $cantidad;
			$updateExistencia = MovimientoProducto::where('id', $venta_detalle->movimiento_producto_id)
			->update(['existencias' => $newExistencias]);

			$ventamaestro = VentaMaestro::where('id', $venta_detalle->venta_id)
			->get()->first();
			$total = $ventamaestro->total_venta;
			$totalresta = $venta_detalle->subtotal;
			$newTotal = $total - $totalresta;
			$updateTotal = VentaMaestro::where('id', $venta_detalle->venta_id)
			->update(['total_venta' => $newTotal]);

			
			$venta_detalle->delete();
			$response["response"] = "El registro ha sido borrado";
			return Response::json( $response );
		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}
	}

	public function destroyDetalle2(VentaDetalle $venta_detalle, MovimientoProducto $movimiento_producto, Request $request)
	{
		$existencias = $movimiento_producto->existencias;
		$cantidad = $venta_detalle->cantidad;
		$newExistencias = $existencias + $cantidad;
		$updateExistencia = MovimientoProducto::where('id', $movimiento_producto->id)
		->update(['existencias' => $newExistencias]);


		$ventamaestro = VentaMaestro::where('id', $venta_detalle->venta_id)
		->get()->first();
		$total = $ventamaestro->total_venta;
		$totalresta = $venta_detalle->subtotal;
		$newTotal = $total - $totalresta;
		$updateTotal = VentaMaestro::where('id', $venta_detalle->venta_id)
		->update(['total_venta' => $newTotal]);

		$venta_detalle->delete();
		$response["response"] = "El registro ha sido borrado";
		return Response::json($response);
	}



	public function getTipoVenta( VentaMaestro $venta_maestro )
	{
		$result = VentaMaestro::where( "id" , "=" , $venta_maestro->id )
		->get()
		->first();
		return Response::json( $result);
	}

	public function makeCorte (Request $request)
	{
		$user1= Auth::user()->password;
		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contraseña es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{

			$user = Auth::user()->name;

			$today = Carbon::now();
			$query = "update ventas_maestro set edo_venta_id=4 where edo_venta_id=1";
			$result = DB::update($query);
			return Response::json( $result  , 200 );
		}
		else {
			$response["password_delete"] = "La contraseña no coincide";
			return Response::json( $response  , 422 );
		}

	}



	public function getJson(Request $params)
	{
		$api_Result = array();
		$today = date("Y/m/d");
		// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("ventas_maestro.id", "ventas_maestro.subtotal_venta", "ventas_maestro.total_venta", "users.name", "estado_ventas.edo_venta", "tipo_ventas.tipo_venta");

		// Initialize query (get all)


		$api_logsQueriable = DB::table('ventas_maestro');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = 'Select TRUNCATE(ventas_maestro.subtotal_venta,4) as subtotal_venta, TRUNCATE(ventas_maestro.total_venta,4) as total_venta, ventas_maestro.id, 
		tipo_ventas.tipo_venta, estado_ventas.edo_venta as edo_venta, users.name as name from ventas_maestro inner join 
		tipo_ventas on ventas_maestro.tipo_venta_id=tipo_ventas.id inner join users on users.id=ventas_maestro.user_id
		inner join estado_ventas on ventas_maestro.edo_venta_id=estado_ventas.id ';

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
		$condition = " where DATE(ventas_maestro.created_at)='".$today."' ";
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

	public function getJsonDetalle(Request $params, $detalle)
	{
		$api_Result = array();
		// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("id", "prod_nombre", "cantidad", "subtotal");

		// Initialize query (get all)


		$api_logsQueriable = DB::table('ventas_detalle');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = 'Select venta_id As No_Venta, TRUNCATE(subtotal,4) as subtotal, ventas_detalle.id, cantidad, prod_nombre from ventas_detalle  inner join productos on ventas_detalle.producto_id=productos.id where venta_id='.$detalle.' ';

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


	public function rpt_ventasuf()
	{
		$query = "SELECT vm.id, vm.created_at, tv.tipo_venta, vm.total_venta, us.name, ev.edo_venta
		FROM ventas_maestro vm 
		INNER JOIN ventas_detalle vd ON vd.venta_id=vm.id
		INNEr JOIN tipo_ventas tv ON tv.id=vm.tipo_venta_id
		INNER JOIN estado_ventas ev ON ev.id=vm.edo_venta_id
		INNER JOIN users us ON us.id=vm.user_id
		GROUP BY vm.id, vm.created_at, tv.tipo_venta, vm.total_venta, us.name, ev.edo_venta ";

		$query2 = "SELECT us.id, us.name
		FROM users us
		INNER JOIN role_user ru ON us.id=ru.user_id
		WHERE ru.role_id in (2, 3) ";

		$rpt_ventauf = DB::select($query);
		$lst_user = DB::select($query2);
		return View::make('reportes.ventasuf', compact('rpt_ventauf', 'lst_user'));
	}


	public function getJsonVentasuf(Request $params)
	{
		$api_Result = array();
		// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("vm.id", "vm.created_at", "vm.total_venta", "us.name" );

		// Initialize query (get all)

		$api_logsQueriable = DB::table('ventas_maestro');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = "SELECT vm.id as id, vm.created_at as fec, tv.tipo_venta as tventa, vm.total_venta as tot, us.name as user, ev.edo_venta as estado
		FROM ventas_maestro vm 
		INNER JOIN ventas_detalle vd ON vd.venta_id=vm.id
		INNEr JOIN tipo_ventas tv ON tv.id=vm.tipo_venta_id
		INNER JOIN estado_ventas ev ON ev.id=vm.edo_venta_id
		INNER JOIN users us ON us.id=vm.user_id ";

		$where = "";

		if (isset($params->search['value']) && !empty($params->search['value'])){

			foreach ($columnsMapping as $column) {
				if (strlen($where) == 0) {
					$where .=" where (".$column." like  '%".$params->search['value']."%' ";
				} else {
					$where .=" or ".$column." like  '%".$params->search['value']."%' ";
				}
			}
			$where .= ') ';
		}

		$query = $query . $where;

		// Sorting
		$sort = "";
			//foreach ($params->order as $order) {
			//	if (strlen($sort) == 0) {
			//		$sort .= ' order by ' . $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
			//	} else {
			//		$sort .= ' , '. $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
			//	}
			//}

		$filter = " limit ".$params->length." offset ".$params->start."";
		$group = " GROUP BY vm.id, vm.created_at, tv.tipo_venta, vm.total_venta, us.name, ev.edo_venta ";

		$data =  $query . $sort . $group;
		$result = DB::select($data);

		$api_Result['recordsFiltered'] = count($result);

		$query .= $sort . $group . $filter;

		$result = DB::select($query);

		$api_Result['data'] = $result;

		return Response::json( $api_Result );
	}
}
