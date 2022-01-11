<?php

namespace App\Http\Controllers;

use App\Proveedor;
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

class ProveedorController extends Controller
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
        return view("proveedor.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $back = "proveedor";
        return view("proveedor.create" , compact( "back" ) );
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
        $proveedor = Proveedor::create($data);

        return Redirect::route('proveedor.index');
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

    public function getName( Proveedor $proveedor )
    {
        $proveedor = Proveedor::where( "proveedores.id" , "=" , $proveedor->id )
        ->select( "proveedores.id","proveedores.nit", "proveedores.nombre_comercial" , "proveedores.nombre_contable", "proveedores.telefonos")
        ->get()
        ->first();
        return Response::json( $proveedor);
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
    
    public function update( Proveedor $proveedor, Request $request )
    {
        // if( $user->email != $request["email"]  )
        //     $validator = $this->updateValidator($request->all());
        // else
        //     $validator = $this->updateValidatorWithoutEmail($request->all());

        // if ($validator->fails()) {
        //     $this->throwValidationException(
        //         $request, $validator
        //         );
        // }

        return Response::json( $this->updateProveedor($proveedor , $request->all()));
    }

    public function updateProveedor( Proveedor $proveedor , array $data )
    {
        $id= $proveedor->id;
        $proveedor->nombre_comercial = $data["nombre_comercial"];
        $proveedor->telefonos = $data["telefonos"];
        $proveedor->save();
        return $proveedor;
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proveedor $proveedor, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $proveedor->delete();
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
        // Create a mapping of our query fields in the order that will be shown in datatable.
        $columnsMapping = array("id", "nit", "nombre_comercial", "telefonos");
        // Initialize query (get all)
        $api_logsQueriable = DB::table('proveedores');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'SELECT id, nit, nombre_comercial, telefonos FROM proveedores ';

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
                $sort .= ' order by ' . $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
            } else {
                $sort .= ', '. $columnsMapping[$order['column']] . ' '. $order['dir']. ' ';
            }
        }

        $result = DB::select($query);
        $api_Result['recordsFiltered'] = count($result);

        $filter = " limit ".$params->length." offset ".$params->start." ";

        $query .= $sort . $filter;
        
        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}
