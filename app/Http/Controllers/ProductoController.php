<?php

namespace App\Http\Controllers;

use App\Producto;
use App\MovimientoProducto;
use App\VentaDetalle;
use App\EstadoProducto;
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


class ProductoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	// public function __construct()
	// {
	//     $this->middleware('auth');
	// }

	
	public function rpt_ganancia()
	{
		$query = "SELECT Date(PR.created_at) as Fecha, PR.id as Codigo, PR.prod_nombre AS Producto, SUM(VD.cantidad) AS Cantidad_Vendida, PR.precio_compra AS Precio_Costo, SUM(VD.cantidad)*PR.precio_compra AS Total_Costo, PR.precio_venta AS Precio_Venta, SUM(VD.cantidad)*PR.precio_venta AS Total_Venta,(SUM(VD.cantidad)*PR.precio_venta)-(SUM(VD.cantidad)*PR.precio_compra) AS Ganancia FROM productos PR INNER JOIN ventas_detalle VD ON PR.id=VD.producto_id WHERE PR.tienda_id = 1 GROUP BY PR.id, PR.prod_nombre ORDER BY PR.id, PR.prod_nombre ASC";

		$rpt_ganancia = DB::select($query);
		return View::make('reportes.ganancias', compact('rpt_ganancia'));
	}

	public function rpt_existencias()
	{
		$query = "SELECT PR.id AS Codigo, PR.codigobarra AS Codigo_Barra, PR.prod_nombre AS Producto, IF(MP.precio_compra IS NULL,0,ROUND(MP.precio_compra,4)) AS Precio_Compra, IF(SUM(MP.existencias) IS NULL,0,SUM(MP.existencias)) AS Existencias, IF(SUM(MP.existencias) IS NULL,0,ROUND(SUM(MP.existencias) * MP.precio_compra,4)) AS Total_Neto FROM productos PR LEFT JOIN movimientos_productos MP ON PR.id=MP.producto_id WHERE PR.tienda_id=1 GROUP BY PR.id, PR.codigobarra, MP.precio_compra ORDER BY PR.id ASC, PR.codigobarra ASC ";

		$rpt_existencia = DB::select($query);
		return View::make('reportes.existencias', compact('rpt_existencia'));
	}

	public function rpt_existenciasprod()
	{
		$query = "SELECT PR.id AS Codigo, PR.codigobarra AS Codigo_Barra, PR.prod_nombre AS Producto, if(Sum(MP.existencias) is null,0,Sum(MP.existencias)) as Existencias FROM productos PR LEFT JOIN movimientos_productos MP on PR.id=MP.producto_id WHERE PR.tienda_id=1 GROUP BY PR.id";

		$rpt_existenciaprod = DB::select($query);
		return View::make('reportes.existenciasprod', compact('rpt_existenciaprod'));
	}


	public function rpt_salidas()
	{
		$query = "SELECT DATE(SP.fecha_salida) as Fecha_Salida, PR.id as Codigo, PR.prod_nombre as Producto, TS.tipo_salida as Tipo_Salida, SUM(SP.cantidad_salida) as Cantidad, PR.precio_compra AS Precio2, (PR.precio_compra*SUM(SP.cantidad_salida)) AS Total_Neto FROM productos PR INNER JOIN salidas_productos SP ON SP.producto_id=PR.id INNER JOIN tipos_salida TS ON TS.id=SP.tipo_salida_id GROUP BY PR.id, PR.prod_nombre, TS.tipo_salida ORDER BY PR.id, PR.prod_nombre, TS.tipo_salida";

		$rpt_salida = DB::select($query);
		return View::make('reportes.salidas', compact('rpt_salida'));
	}

	public function rpt_ingresos()
	{
		$query = "SELECT IP.fecha_ingreso AS Fecha_Ingreso, PR.id AS Codigo, PR.prod_nombre AS Producto, SUM(IP.cantidad_ingreso) AS Cantidad FROM productos PR INNER JOIN ingresos_productos IP ON IP.producto_id=PR.id GROUP BY IP.fecha_ingreso, PR.id, PR.prod_nombre ORDER BY PR.id ASC";

		$rpt_ingreso = DB::select($query);
		return View::make('reportes.ingresos', compact('rpt_ingreso'));
	}

	
	public function index()
	{
		$status =  EstadoProducto::all();
		return view("producto.index", compact("status"));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$action='Ingresa a crear un producto';
		$bitacora = HomeController::bitacora($action);

		$back = "producto";

		
		return view("producto.create" , compact("back"));
	}


	public function nombreDisponible($data)
     {
		 $query = Producto::where("prod_nombre", $data)->get();
		 $contador = count($query);
         if ($contador == 0)
         {
			 return 'false';
         }
         else
         {
			return 'true';
         }
	 }

	 public function codigoDisponible($data)
     {
		 $query = Producto::where("codigobarra", $data)->get();
		 $contador = count($query);
         if ($contador == 0)
         {
			 return 'false';
         }
         else
         {
			return 'true';
         }
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
		$data["tienda_id"] = 1;
		$data["edo_producto_id"] =1;
		$data["user_id"] = Auth::user()->id;
		$producto = Producto::create($data);

		$action='Crea producto';
		$bitacora = HomeController::bitacora($action);

		return Redirect::route('producto.index');
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

	public function getName( Producto $producto )
	{

		// $producto2 = Producto::where( "productos.id" , "=" , $producto->id)
		// ->select( "productos.id","productos.prod_nombre", "productos.minimo" , "productos.precio_compra", "productos.precio_venta")
		// ->get()
		// ->first();

		$producto2 = "Select MP.id as producto_id, if(MP.fecha_ingreso is null,0,MP.fecha_ingreso) as fecha, PR.id as prod_id, PR.edo_producto_id,
		PR.prod_nombre, if(MP.existencias is null,0,MP.existencias) as existencias, 
		if(MP.precio_compra is null,0,MP.precio_compra) as precio_compra, PR.codigobarra,
			if(MP.precio_venta is null,0,MP.precio_venta) as precio_venta
				from productos PR
			left join movimientos_productos MP on PR.id=MP.producto_id and (MP.existencias>0)
			having PR.codigobarra = '".$producto->codigobarra."'
			order by MP.fecha_ingreso DESC limit 1";
			$result = DB::select($producto2);
			return Response::json( $result[0]);
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

	public function update(Producto $producto, Request $request )
	{
		return Response::json( $this->updateProducto($producto , $request->all()));
	}

	public function updateProducto( Producto $producto , array $data )
	{
		$id= $producto->id;
		$producto->codigobarra = $data["codigobarra"];
		$producto->prod_nombre = $data["prod_nombre"];
		$producto->precio_venta = $data["precio_venta"];
		$producto->edo_producto_id = $data["edo_producto_id"];
		$producto->save();

		$query = "Select MP.id as producto_id, if(MP.fecha_ingreso is null,0,MP.fecha_ingreso) as fecha, PR.id as prod_id,
		PR.prod_nombre, if(MP.existencias is null,0,MP.existencias) as existencias, 
		if(MP.precio_compra is null,0,MP.precio_compra) as precio_compra, PR.codigobarra,
			if(MP.precio_venta is null,0,MP.precio_venta) as precio_venta
				from productos PR
			left join movimientos_productos MP on PR.id=MP.producto_id and (MP.existencias>0)
			having PR.id = '".$id."'
			order by MP.fecha_ingreso DESC limit 1";
			$result = DB::select($query);

			$movimiento = $result[0]->producto_id;
			$md = MovimientoProducto::where('id', $movimiento)->update(['precio_venta' => $data["precio_venta"]]);

			$action='Actualiza datos de producto';
			$bitacora = HomeController::bitacora($action);

			return $producto;
		}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( Producto $producto, Request $request)
	{
		$user1= Auth::user()->password;

		if ($request["password_delete"] == "")
		{
			$response["password_delete"]  = "La contrase���a es requerida";
			return Response::json( $response  , 422 );
		}
		else if( password_verify( $request["password_delete"] , $user1))
		{
			$action="Elimina producto No '". $producto->id ."' con nombre '". $producto->prod_nombre ."'";
			$bitacora = HomeController::bitacora($action);
			
			$producto->delete();
			$response["response"] = "El registro ha sido borrado";

			return Response::json( $response );
		}
		else {
			$response["password_delete"] = "La contrase���a no coincide";
			return Response::json( $response  , 422 );
		}

	}

	public function getJson(Request $params)
	{
		$api_Result = array();
		// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array("PR.id", "PR.codigobarra", "PR.prod_nombre");

		// Initialize query (get all)


		$api_logsQueriable = DB::table('productos');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = 'SELECT PR.id, PR.codigobarra, PR.prod_nombre, 
		IF((SELECT precio_venta FROM movimientos_productos WHERE producto_id = PR.id 
		ORDER BY fecha_ingreso DESC LIMIT 1) is null,0, (SELECT precio_venta FROM movimientos_productos WHERE producto_id = PR.id 
		ORDER BY fecha_ingreso DESC LIMIT 1)) as precio_venta1, EP.edo_producto 
		FROM productos PR 
		LEFT JOIN movimientos_productos MP ON MP.producto_id=PR.id
		INNER JOIN estado_productos EP ON EP.id=PR.edo_producto_id ';

		$where = "";

		if (isset($params->search['value']) && !empty($params->search['value'])){

			foreach ($columnsMapping as $column) {
				if (strlen($where) == 0) {
					$where .=" where  (".$column." like  '%".$params->search['value']."%' ";
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
		$group = " GROUP BY PR.id, PR.codigobarra, PR.prod_nombre ";

		$query .= $group . $sort . $filter;
		
		$result = DB::select($query);
		$api_Result['data'] = $result;

		return Response::json( $api_Result );
	}

	public function getJsonGanancia(Request $params)
	{
		$api_Result = array();
		// Create a mapping of our query fields in the order that will be shown in datatable.
		$columnsMapping = array( "productos.id","codigobarra","prod_nombre","total_costo","total_venta");

		// Initialize query (get all)

		$api_logsQueriable = DB::table('ventas_detalle');
		$api_Result['recordsTotal'] = $api_logsQueriable->count();

		$query = 'SELECT productos.id as Codigo, productos.codigobarra, productos.prod_nombre, SUM(ventas_detalle.cantidad) as cantidad_vendida, ventas_detalle.precio_compra, (SUM(ventas_detalle.cantidad)*ventas_detalle.precio_compra) as total_costo, ventas_detalle.precio_venta, (SUM(ventas_detalle.cantidad)*ventas_detalle.precio_venta) as total_venta, ((SUM(ventas_detalle.cantidad)*ventas_detalle.precio_venta) - (SUM(ventas_detalle.cantidad)*ventas_detalle.precio_compra)) as ganancia FROM ventas_detalle INNER JOIN productos ON productos.id=ventas_detalle.producto_id  ';

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
		$group = " GROUP BY productos.id, productos.codigobarra, productos.prod_nombre ";

		$data =  $query . $sort . $group;
		$result = DB::select($data);

		$api_Result['recordsFiltered'] = count($result);

		$query .= $sort . $group . $filter;

		$result = DB::select($query);

		$api_Result['data'] = $result;

		return Response::json( $api_Result );
	}


	public function getProductos()
	{
		$productos = Producto::where('edo_producto_id', 1)->get();
		return Response::json($productos);
	}


	public function getInfo(Request $request)
	{
		$producto = $request["data"];

		if ($producto == "")
		{
			$result = "";
			return Response::json( $result);
		}
		else {
			$query = "Select MP.id as producto_id, if(MP.fecha_ingreso is null,0,MP.fecha_ingreso) as fecha, PR.id as prod_id,
			PR.prod_nombre, if(MP.existencias is null,0,MP.existencias) as existencias, 
			if(MP.precio_compra is null,0,MP.precio_compra) as precio_compra, PR.codigobarra,
				if(MP.precio_venta is null,0,MP.precio_venta) as precio_venta
					from productos PR
				left join movimientos_productos MP on PR.id=MP.producto_id and (MP.existencias>0)
				where PR.edo_producto_id = 1
				having PR.id = '".$producto."'
				order by MP.fecha_ingreso DESC limit 1";
				$result = DB::select($query);
				return Response::json( $result);
			}

		}

		public function getInfoPartida(Request $request)
		{
			$producto = $request["data"];
			$mov = $request["mov"];

			if ($producto == "")
			{
				$result = "";
				return Response::json( $result);
			}
			else {
				if ($mov == 1)
				{
					$query = "Select MP.id as producto_id, if(MP.fecha_ingreso is null,0,MP.fecha_ingreso) as fecha, PR.id as prod_id,
					PR.prod_nombre, if(MP.existencias is null,0,MP.existencias) as existencias, 
					if(MP.precio_compra is null,0,MP.precio_compra) as precio_compra, PR.codigobarra,
						if(MP.precio_venta is null,0,MP.precio_venta) as precio_venta
							from productos PR
						left join movimientos_productos MP on PR.id=MP.producto_id and (MP.existencias>=0)
						having PR.id = '".$producto."'
						order by MP.fecha_ingreso DESC limit 1";
						$result = DB::select($query);
						return Response::json( $result);
					}
					else if ($mov == 2)
					{
						$query = "Select MP.id as producto_id, if(MP.fecha_ingreso is null,0,MP.fecha_ingreso) as fecha, PR.id as prod_id,
						PR.prod_nombre, if(MP.existencias is null,0,MP.existencias) as existencias, 
						if(MP.precio_compra is null,0,MP.precio_compra) as precio_compra, PR.codigobarra,
							if(MP.precio_venta is null,0,MP.precio_venta) as precio_venta
								from productos PR
							left join movimientos_productos MP on PR.id=MP.producto_id and (MP.existencias>0)
							having PR.id = '".$producto."'
							order by MP.fecha_ingreso DESC limit 1";
							$result = DB::select($query);
							return Response::json( $result);
						}
					}

				}



				public function getJsonExistencia(Request $params)
				{
					$api_Result = array();
					$columnsMapping = array( "productos.id", "codigobarra", "prod_nombre", "movimientos_productos.precio_compra", "existencias");


					$api_logsQueriable = DB::table('productos');
					$api_Result['recordsTotal'] = $api_logsQueriable->count();

					$query = 'SELECT productos.id AS Codigo, productos.codigobarra, productos.prod_nombre, IF(movimientos_productos.precio_compra IS NULL,0,ROUND(movimientos_productos.precio_compra,4)) AS precio_compra, IF(SUM(movimientos_productos.existencias) IS NULL,0,SUM(movimientos_productos.existencias)) AS existencias, IF(SUM(movimientos_productos.existencias) IS NULL,0,ROUND(SUM(movimientos_productos.existencias) * movimientos_productos.precio_compra,4)) AS total_neto FROM productos  LEFT JOIN movimientos_productos ON productos.id=movimientos_productos.producto_id  ';

					$where = "";

					if (isset($params->search['value']) && !empty($params->search['value'])){

						foreach ($columnsMapping as $column) {
							if (strlen($where) == 0) {
								$where .=" where (".$column." like  '%".$params->search['value']."%' ";
							} else {
								$where .=" or ".$column." like  '%".$params->search['value']."%' ";
							}

						}
						$where .= ' and productos.edo_producto_id=1) ';
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
					$group = " GROUP BY productos.id, productos.codigobarra, movimientos_productos.precio_compra ";

					$data =  $query . $sort . $group;
					$result = DB::select($data);

					$api_Result['recordsFiltered'] = count($result);

					$query .= $sort . $group . $filter;

					$result = DB::select($query);

					$api_Result['data'] = $result;

					return Response::json( $api_Result );
				}


				public function getJsonExistenciaProd(Request $params)
				{
					$api_Result = array();
		// Create a mapping of our query fields in the order that will be shown in datatable.
					$columnsMapping = array("productos.codigobarra", "productos.prod_nombre");

		// Initialize query (get all)

					$api_logsQueriable = DB::table("productos");
					$api_Result["recordsTotal"] = $api_logsQueriable->count();

					$query = 'SELECT productos.id, productos.codigobarra, productos.prod_nombre, if(Sum(movimientos_productos.existencias) is null,0,Sum(movimientos_productos.existencias)) as existencias FROM productos LEFT JOIN movimientos_productos on productos.id=movimientos_productos.producto_id ';

					$where = "";

					if (isset($params->search['value']) && !empty($params->search['value'])){

						foreach ($columnsMapping as $column) {
							if (strlen($where) == 0) {
								$where .=" where (".$column." like  '%".$params->search['value']."%' ";
							} else {
								$where .=" or ".$column." like  '%".$params->search['value']."%' ";
							}

						}
						$where .= ' and productos.edo_producto_id=1) ';
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
					$group = " GROUP BY productos.id, productos.codigobarra, productos.prod_nombre ";


					$data =  $query . $sort . $group;
					$result = DB::select($data);

					$api_Result['recordsFiltered'] = count($result);

					$query .= $sort . $group . $filter;

					$result = DB::select($query);

					$api_Result['data'] = $result;

					return Response::json( $api_Result );
				}


				public function getJsonIngreso(Request $params)
				{
					$api_Result = array();
		// Create a mapping of our query fields in the order that will be shown in datatable.
					$columnsMapping = array( "ingresos_detalle.fecha_ingreso", "productos.id", "productos.codigobarra", "productos.prod_nombre", "ingresos_detalle.precio_compra" );

		// Initialize query (get all)


					$api_logsQueriable = DB::table('ingresos_detalle');
					$api_Result['recordsTotal'] = $api_logsQueriable->count();

					$query = 'SELECT DATE_FORMAT(ingresos_detalle.fecha_ingreso, "%d-%m-%Y") as fecha_ingreso, productos.id as Codigo, productos.codigobarra, productos.prod_nombre, ingresos_detalle.existencias, ingresos_detalle.precio_compra, (ingresos_detalle.existencias * ingresos_detalle.precio_compra) as total_neto FROM ingresos_detalle INNER JOIN productos ON productos.id=ingresos_detalle.producto_id ';

					$where = '';

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
			/*foreach ($params->order as $order) {
				if (strlen($sort) == 0) {
					$sort .= ' order by ' . $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
				} else {
					$sort .= ' , '. $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
				}
			}*/

			$result = DB::select($query);
			$api_Result['recordsFiltered'] = count($result);

			$filter = " limit ".$params->length." offset ".$params->start."";

			$group = " GROUP BY productos.id, productos.codigobarra, ingresos_detalle.precio_compra ";
			$query .= $sort . $group . $filter;

			$result = DB::select($query);
			$api_Result['data'] = $result;

			return Response::json( $api_Result );
		}


		public function getJsonSalida(Request $params)
		{
			$api_Result = array();
		// Create a mapping of our query fields in the order that will be shown in datatable.
			$columnsMapping = array( "codigobarra", "prod_nombre", "tipo_salida");

		// Initialize query (get all)


			$api_logsQueriable = DB::table('salidas_productos');
			$api_Result['recordsTotal'] = $api_logsQueriable->count();

			$query = 'SELECT DATE(SP.fecha_salida) as Fecha_Salida, PR.codigobarra as Codigo, PR.prod_nombre as Producto, TS.tipo_salida as Tipo_Salida, SUM(SP.cantidad_salida) as Cantidad, PR.precio_compra AS PrecioCompra, (PR.precio_compra*SUM(SP.cantidad_salida)) AS Total_Neto FROM productos PR INNER JOIN salidas_productos SP ON SP.producto_id=PR.id INNER JOIN tipos_salida TS ON TS.id=SP.tipo_salida_id ';

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
			/*foreach ($params->order as $order) {
				if (strlen($sort) == 0) {
					$sort .= ' order by ' . $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
				} else {
					$sort .= ' , '. $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
				}
			}*/

			$result = DB::select($query);
			$api_Result['recordsFiltered'] = count($result);

			$filter = " limit ".$params->length." offset ".$params->start."";
			$group = " GROUP BY SP.fecha_salida,PR.id, PR.prod_nombre, TS.tipo_salida ";
			$query .= $sort . $group . $filter;

			$result = DB::select($query);
			$api_Result['data'] = $result;

			return Response::json( $api_Result );
		}

		public function getJsonComprasFactura(Request $params)
		{
			$api_Result = array();
		// Create a mapping of our query fields in the order that will be shown in datatable.
			$columnsMapping = array("serie_factura", "num_factura","fecha_factura", "nombre_comercial","total_factura");

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
	}
