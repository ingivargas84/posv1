<?php

namespace App\Http\Controllers;

use App\Empleado;
use App\Cargo;
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

class EmpleadoController extends Controller
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
        $cargos = Cargo::all();
        return view("empleado.index", compact("cargos"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $back = "empleado";
        $cargos = Cargo::all();
        return view("empleado.create" , compact( "back", "cargos" ) );
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
        $data['tienda_id'] = 1;
        $data['edo_empleado_id'] = 1;
        $data['cargo_id'] = 6;
        $empleado = Empleado::create($data);

        return Redirect::route('empleado.index');
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

public function getName( Empleado $empleado )
    {
        $empleadoN = Empleado::where( "empleados.id" , "=" , $empleado->id )
        ->select( "empleados.id","empleados.emp_cui", "empleados.emp_nombres" , "empleados.emp_apellidos", "empleados.emp_direccion", "empleados.emp_telefonos", "empleados.cargo_id", "empleados.tienda_id", "empleados.edo_empleado_id")
        ->get()
        ->first();
        return Response::json($empleadoN);
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
     public function update( Empleado $empleado, Request $request )
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

        return Response::json( $this->updateEmpleado($empleado , $request->all()));
    }


    public function updateEmpleado( Empleado $empleado , array $data )
    {
        $id= $empleado->id;
        $empleado->emp_telefonos = $data["emp_telefonos"];
        $empleado->emp_direccion = $data["emp_direccion"];
        $empleado->save();
        return $empleado;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function destroy(Empleado $empleado, Request $request)
    {
        $user1= Auth::user()->password;

        if ($request["password_delete"] == "")
        {
            $response["password_delete"]  = "La contraseña es requerida";
            return Response::json( $response  , 422 );
        }
        else if( password_verify( $request["password_delete"] , $user1))
        {
            $empleado->delete();
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
        $columnsMapping = array("empleados.emp_cui", "empleados.emp_nombres" , "empleados.emp_apellidos", "empleados.emp_direccion", "empleados.emp_telefonos");

        // Initialize query (get all)


        $api_logsQueriable = DB::table('empleados');
        $api_Result['recordsTotal'] = $api_logsQueriable->count();

        $query = 'Select empleados.id, empleados.emp_cui, empleados.emp_nombres, empleados.emp_apellidos, empleados.emp_direccion, empleados.emp_telefonos, empleados.edo_empleado_id FROM empleados INNER JOIN cargos ON cargos.id=empleados.cargo_id ';

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
