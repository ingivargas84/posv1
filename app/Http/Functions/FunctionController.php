<?php

namespace App\Http\Functions;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Kodeine\Acl\Models\Eloquent\Role;
use Kodeine\Acl\Models\Eloquent\Permission;
use DB;
use Kodeine\Acl\Traits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Kodeine\Acl\Traits\HasPermission;

class FunctionController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Return user with role
     * @param $user
     * @return mixed
     */

    public static function getUsers()
    {
        $userSelect = ('Select users.id, users.name, users.email, roles.name as role from role_user inner join users
            on users.id=role_user.user_id inner join roles on role_user.role_id=roles.id
            where roles.slug="administrator" or roles.slug="viewer"');
        $results= DB::select($userSelect);
        return $results;
    }


    public static function getRoles()
    {
        $userSelect = ('Select roles.id, roles.name from roles where roles.name!="SuperAdmin"');
        $results= DB::select($userSelect);
        return $results;
    }

    public static function getUser( $user )
    {

        $userSelect = ('Select users.id, users.name, users.email, roles.name as role from role_user inner join users
            on users.id=role_user.user_id inner join roles on role_user.role_id=roles.id
            where users.id = '.$user.' and (roles.slug="administrator" or roles.slug="consulta" or roles.slug="vendedor" or roles.slug="consulta_central")');
        $results= DB::select($userSelect);
        return $results;

    }
    public static function createMaster(  )
    {
        $exists = User::get();
        if( count( $exists ) == 0 )
        {
            $user = new User;
            $user->name = "Admin";
            $user->password = bcrypt("admin");
            $user->email = "admin@pos.com";
            $user->save();

            $role = FunctionController::createRole( array(
                "name" => "SuperAdmin",
                "slug" => "superadmin",
                "description" => "manage all privileges"
                ));


            $permission = array( 
                FunctionController::createPermission("users"),
                FunctionController::createPermission("role_user"),
                FunctionController::createPermission("roles"),
                FunctionController::createPermission("permission_role"),
                FunctionController::createPermission("permission_user"),
                FunctionController::createPermission("permissions"),
                FunctionController::createPermission("migrations"),
                FunctionController::createPermission("password_resets"),
                FunctionController::createPermission("bitacoras"),
                FunctionController::createPermission("estados_ctsx_cobrar"),
                FunctionController::createPermission("ctsx_cobrar_maestro"),
                FunctionController::createPermission("ctsx_cobrar_detalle"),
                FunctionController::createPermission("departamentos"),
                FunctionController::createPermission("municipios"),
                FunctionController::createPermission("tiendas"),
                FunctionController::createPermission("tipo_ventas"),
                FunctionController::createPermission("ventas_maestro"),
                FunctionController::createPermission("ventas_detalle"),
                FunctionController::createPermission("estado_ventas"),
                FunctionController::createPermission("empleados"),
                FunctionController::createPermission("estado_empleados"),
                FunctionController::createPermission("cargos"),
                FunctionController::createPermission("tipos_salida"),
                FunctionController::createPermission("tipos_ajustes"),
                FunctionController::createPermission("tipos_movimientos"),
                FunctionController::createPermission("salidas_productos"),
                FunctionController::createPermission("ingresos_productos"),
                FunctionController::createPermission("productos"),
                FunctionController::createPermission("estado_productos"),
                FunctionController::createPermission("estado_ingresos"),
                FunctionController::createPermission("proveedores"),
                FunctionController::createPermission("ingresos_detalle"),
                FunctionController::createPermission("ingresos_maestro"),
                FunctionController::createPermission("metodos_inventarios"),
                FunctionController::createPermission("movimientos_ctaxcobrar"),
                FunctionController::createPermission("movimientos_productos"),
                FunctionController::createPermission("partidas_ajustes")
                );
            $role->assignPermission(  $permission );
            $user->assignRole($role);
            $role2 = FunctionController::createRole( array(
                "name" => "Administrador",
                "slug" => "administrator",
                "description" => "manage all privileges"
                ));
            $permission2 = array( 
                FunctionController::createPermission("ctsx_cobrar_maestro"),
                FunctionController::createPermission("ctsx_cobrar_detalle"),
                FunctionController::createPermission("ventas_maestro"),
                FunctionController::createPermission("ventas_detalle"),
                FunctionController::createPermission("empleados"),
                FunctionController::createPermission("bitacoras"),
                FunctionController::createPermission("cargos"),
                FunctionController::createPermission("salidas_productos"),
                FunctionController::createPermission("ingresos_productos"),
                FunctionController::createPermission("ingresos_detalle"),
                FunctionController::createPermission("ingresos_maestro"),
                FunctionController::createPermission("movimientos_ctaxcobrar"),
                FunctionController::createPermission("movimientos_productos"),
                FunctionController::createPermission("tipos_movimientos"),
                FunctionController::createPermission("productos"),
                FunctionController::createPermission("proveedores")
                );
            $role2->assignPermission($permission2);
            $role3 = FunctionController::createRole( array(
                "name" => "Cajero",
                "slug" => "cajero",
                "description" => "manage all privileges"
                ));
            $permission3 = array( 
                FunctionController::createPermission("ctsx_cobrar_maestro"),
                FunctionController::createPermission("ctsx_cobrar_detalle"),
                FunctionController::createPermission("movimientos_productos"),
                FunctionController::createPermission("productos"),
                FunctionController::createPermission("bitacoras"),
                FunctionController::createPermission("ventas_maestro"),
                FunctionController::createPermission("ventas_detalle")
                );
            $role3->assignPermission($permission3);

            $role4 = FunctionController::createRole( array(
                "name" => "Consulta",
                "slug" => "consulta",
                "description" => "manage all privileges"
                ));
            $permission4 = array( 
                FunctionController::createPermission("users"),
                FunctionController::createPermission("role_user"),
                FunctionController::createPermission("roles"),
                FunctionController::createPermission("permission_role"),
                FunctionController::createPermission("permission_user"),
                FunctionController::createPermission("permissions"),
                FunctionController::createPermission("migrations"),
                FunctionController::createPermission("password_resets"),
                FunctionController::createPermission("bitacoras"),
                FunctionController::createPermission("ingresos_detalle"),
                FunctionController::createPermission("ingresos_maestro"),
                FunctionController::createPermission("productos"),
                FunctionController::createPermissionRead("ctsx_cobrar_maestro"),
                FunctionController::createPermissionRead("ctsx_cobrar_detalle"),
                FunctionController::createPermissionRead("ventas_maestro"),
                FunctionController::createPermissionRead("ventas_detalle"),
                FunctionController::createPermissionRead("empleados"),
                FunctionController::createPermissionRead("cargos"),
                FunctionController::createPermissionRead("movimientos_productos"),
                FunctionController::createPermissionRead("productos"),
                FunctionController::createPermissionRead("salidas_productos"),
                FunctionController::createPermissionRead("ingresos_productos"),
                FunctionController::createPermissionRead("proveedores")
                );
            $role4->assignPermission($permission4);

            $role5 = FunctionController::createRole( array(
                "name" => "Propietario",
                "slug" => "consulta_central",
                "description" => "manage all privileges"
                ));
            $permission5 = array( 
                FunctionController::createPermission("users"),
                FunctionController::createPermission("role_user"),
                FunctionController::createPermission("roles"),
                FunctionController::createPermission("permission_role"),
                FunctionController::createPermission("permissions"),
                FunctionController::createPermissionRead("bitacoras"),
                FunctionController::createPermissionRead("estados_ctsx_cobrar"),
                FunctionController::createPermissionRead("ctsx_cobrar_maestro"),
                FunctionController::createPermissionRead("ctsx_cobrar_detalle"),
                FunctionController::createPermissionRead("departamentos"),
                FunctionController::createPermissionRead("municipios"),
                FunctionController::createPermissionRead("tiendas"),
                FunctionController::createPermissionRead("tipo_ventas"),
                FunctionController::createPermissionRead("ventas_maestro"),
                FunctionController::createPermissionRead("ventas_detalle"),
                FunctionController::createPermissionRead("estado_ventas"),
                FunctionController::createPermissionRead("empleados"),
                FunctionController::createPermissionRead("estado_empleados"),
                FunctionController::createPermissionRead("cargos"),
                FunctionController::createPermissionRead("tipos_salida"),
                FunctionController::createPermissionRead("salidas_productos"),
                FunctionController::createPermissionRead("ingresos_productos"),
                FunctionController::createPermissionRead("productos"),
                FunctionController::createPermissionRead("estado_productos"),
                FunctionController::createPermissionRead("estado_ingresos"),
                FunctionController::createPermissionRead("proveedores")
                );
            $role5->assignPermission($permission5);
        }
    }
    



    public static function createRole(array $data)
    {
        return Role::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'],
            ]);
    }

    /**
     * Create a new permission
     * @param $name
     * @return static
     */

    public static function createPermission( $name )
    {
        $permission = new Permission();
        return $permission->create([
            'name'        => $name,
            'slug'        => [          // pass an array of permissions.
            'create'     => true,
            'view'       => true,
            'update'     => true,
            'delete'     => true
            ],
            'description' => 'manage '.$name.' permissions'
            ]);
    }

    public static function createPermissionRead( $name )
    {
        $permission = new Permission();
        return $permission->create([
            'name'        => $name,
            'slug'        => [          // pass an array of permissions.
            'view'       => true
            ],
            'description' => 'manage '.$name.' permissions'
            ]);
    }

    public function assignRole($role)
    {
        return $this->roles()->save(
            Role::whereName($role)->firstOrFail()
            );
    }

}
