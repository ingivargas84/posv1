<?php

namespace App\Http\Controllers;

use App\IngresoProducto;
use App\IngresoMaestro;
use App\User;
use App\EstadoIngreso;
use App\Proveedor;
use App\Producto;
use App\MovimientoProducto;
use App\IngresoDetalle;
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

class IngresoProductoController extends Controller
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
		$proveedores = Proveedor::all();
		$productos = Producto::all();
		return view("ingresoproducto.index", compact("proveedores", "productos"));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$back = "ingresoproducto";
		$proveedores = Proveedor::all();
		$productos = Producto::all();
		return view("ingresoproducto.create" , compact( "back", "proveedores", "productos") );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(Request $request)
	{
		// $data = $request->all();
		// $codigobarra = $data["codigobarra"];
		// $producto1 = "Select productos.id from productos where codigobarra='".$codigobarra."'";
		// $result = DB::select($producto1);
		// foreach($result as $results){
		// 	$data["producto_id"] = $results->id;
		// }
		// $data["edo_ingreso_id"] = 1;
		// $data['fecha_ingreso'] = Carbon::createFromFormat('d-m-Y', $data['fecha_ingreso']);
		// $data['fecha_factura'] = Carbon::createFromFormat('d-m-Y', $data['fecha_factura']);
		// $data["user_id"] = Auth::user()->id;
		// $ingresoproducto = IngresoProducto::create($data);
		// $producto = Producto::where('id', $data["producto_id"])
		// ->get()->first();
		// $existencias = $producto->existencias;
		// $cantidad = $data["cantidad_ingreso"];
		// $newExistencias = $existencias + $cantidad;
		// $updateExistencia = Producto::where('id', $data["producto_id"])
		// ->update(['existencias' => $newExistencias]);
		// return Redirect::route('ingresoproducto.index');
	}


	public function save(Request $request)
	{
		$data = $request->all();
		$data["user_id"] = Auth::user()->id;
		$data['fecha_factura'] = Carbon::createFromFormat('d-m-Y', $data['fecha_factura']);
		$data["edo_ingreso_id"] = 1;
		$maestro = IngresoMaestro::create($data);
		return $maestro;
	}


	public function saveDetalle(Request $request, IngresoMaestro $ingreso_maestro)
	{
		$statsArray = $request->all();
		foreach($statsArray as $stat) {
			$stat['user_id'] = Auth::user()->id;
			$stat["subtotal"] = $stat["subtotal_venta"];
			$stat['producto_id'] = $stat['producto_id'];
			$stat['existencias'] = $stat["cantidad"];
			$stat["precio_compra"] = $stat["precio_compra"];
			$stat["precio_venta"] = $stat["precio_venta"];
			$stat['fecha_ingreso'] = Carbon::now();
			$detalle = MovimientoProducto::create($stat);
			$stat["movimiento_producto_id"] = $detalle->id;
			$ingreso_maestro->ingresodetalle()->create($stat);
			
		}
		return Response::json(['result' => 'ok']);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */


	public function show(IngresoMaestro $ingreso_maestro)
	{
		return view('ingresoproducto.show')->with('ingreso_maestro', $ingreso_maestro);
	}


	public function getName(IngresoMaestro $ingreso_maestro )
	{
		$date = Carbon::createFromFormat('Y-m-d', $ingreso_maestro->fecha_factura)->format('d-m-Y');
		$ingreso_maestro->fecha_factura = $date;
		return Response::json($ingreso_maestro);
	}

	public function getDetalle( IngresoDetalle $ingreso_detalle)
	{
		$ingresoproducto = IngresoDetalle::where( "ingresos_detalle.id" , "=" , $ingreso_detalle->id )
		->select( "existencias", "precio_compra", "precio_venta")
		->get()
		->first();
		return Response::json( $ingresoproducto);
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


	public function update( IngresoMaestro $ingreso_maestro, Request $request )
	{
		
		return Response::json( $this->updateIngresoProducto($ingreso_maestro, $request->all())); 
	}



	public function updateIngresoProducto(IngresoMaestro $ingreso_maestro, array $data )
	{
		$data['fecha_factura'] = Carbon::createFromFormat('d-m-Y', $data['fecha_factura']);
		$ingreso_maestro->serie_factura = $data["serie_factura"];
		$ingreso_maestro->num_factura = $data["num_factura"];
		$ingreso_maestro->fecha_factura = $data["fecha_factura"];
		$ingreso_maestro->proveedor_id = $data["proveedor_id"];
		$ingreso_maestro->save();
		return $ingreso_maestro;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( IngresoMaestro $ingreso_maestro,  Request $request)
	{
		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contrase単a es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$detalles = IngresoDetalle::where('ingreso_maestro_id', $ingreso_maestro->id)
			->get();
			foreach($detalles as $detalle) 
			{
				$producto = MovimientoProducto::where('id', $detalle["movimiento_producto_id"])
				->get()->first();
				$newExistencias = 0;
				$updateExistencia = MovimientoProducto::where('id', $detalle["movimiento_producto_id"])
				->update(['existencias' => $newExistencias]);
			}
			$ingreso_maestro->delete();
			$response["response"] = "El registro ha sido borrado";
			return Response::json( $response );
		}
		else {
			$response["password_delete"] = "La contrase単a no coincide";
			return Response::json( $response  , 422 );
		}
	}

	public function destroyDetalle(IngresoDetalle $ingreso_detalle,  Request $request)
	{
		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contrase単a es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$producto = MovimientoProducto::where('id', $ingreso_detalle->movimiento_producto_id)
			->get()->first();
			$existencias = $producto->existencias;
			$cantidad = $ingreso_detalle->existencias;
			$newExistencias = $existencias - $cantidad;
			$updateExistencia = MovimientoProducto::where('id', $ingreso_detalle->movimiento_producto_id)
			->update(['existencias' => $newExistencias]);


			$ingresomaestro = IngresoMaestro::where('id', $ingreso_detalle->ingreso_maestro_id)
			->get()->first();
			$total = $ingresomaestro->total_factura;
			$totalresta = ($ingreso_detalle->precio_compra * $ingreso_detalle->existencias);
			$newTotal = $total - $totalresta;
			$updateTotal = IngresoMaestro::where('id', $ingreso_detalle->ingreso_maestro_id)
			->update(['total_factura' => $newTotal]);


			$ingreso_detalle->delete();
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
$columnsMapping = array("ingresos_maestro.id","ingresos_maestro.serie_factura", "ingresos_maestro.num_factura","fecha_factura", "proveedores.nombre_comercial","total");

		// Initialize query (get all)

		$api_logsQueriable = DB::table("ingresos_maestro");
		$api_Result["recordsTotal"] = $api_logsQueriable->count();

		$query = 'SELECT ingresos_maestro.id, ingresos_maestro.serie_factura, ingresos_maestro.num_factura, DATE_FORMAT(ingresos_maestro.fecha_factura, "%d-%m-%Y") as fecha_factura, proveedores.nombre_comercial, TRUNCATE(ingresos_maestro.total_factura,2) as total FROM ingresos_maestro INNER JOIN proveedores ON proveedores.id=ingresos_maestro.proveedor_id ';

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
		$columnsMapping = array("ingresos_detalle.ingreso_maestro_id", "productos.codigobarra", "productos.prod_nombre", "ingresos_detalle.existencias", "ingresos_detalle.precio_compra", "ingresos_detalle.precio_venta");

		// Initialize query (get all)


		$api_logsQueriable = DB::table('ingresos_detalle');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = 'SELECT ingresos_detalle.id, ingresos_detalle.ingreso_maestro_id, productos.codigobarra, productos.prod_nombre, ingresos_detalle.existencias, ingresos_detalle.precio_compra, ingresos_detalle.precio_venta FROM ingresos_detalle INNER JOIN productos ON ingresos_detalle.producto_id=productos.id WHERE ingresos_detalle.ingreso_maestro_id ='.$detalle.' ';

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
				$sort .= ' order by ' . $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
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
