<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function($tabla)
        {
            $tabla->increments('id');
            $tabla->string('emp_cui',13);
            $tabla->string('emp_nombres',50);
            $tabla->string('emp_apellidos',50);
            $tabla->string('emp_direccion',50);
            $tabla->string('emp_telefonos', 30);

            $tabla->integer('cargo_id')->unsigned()->nullable();
            $tabla->foreign('cargo_id')->references('id')->on('cargos')->onDelete('cascade');

            $tabla->integer('tienda_id')->unsigned()->nullable();
            $tabla->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('cascade');

            $tabla->integer('edo_empleado_id')->unsigned()->nullable();
            $tabla->foreign('edo_empleado_id')->references('id')->on('estado_empleados')->onDelete('cascade');

            $tabla->integer('user_id')->unsigned()->nullable();
            $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //campos para controlar inserts y updates
            //created_at updated_at
            $tabla->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('empleados');
    }
}
