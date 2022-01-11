<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedEstadoEmpleadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('estado_empleados')->insert(
            array(
                array('edo_empleado' => 'Activo'),
                array('edo_empleado' => 'Suspedido'),
                array('edo_empleado' => 'de Baja'),
                )
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('estado_empleados')->delete();
    }
}
