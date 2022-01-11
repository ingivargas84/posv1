<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtsxCobrarMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctsx_cobrar_maestro', function($tabla)
        {
            $tabla->increments('id');
            $tabla->date('fecha');
            $tabla->float('total_x_cobrar');

            $tabla->integer('user_id')->unsigned()->nullable();
            $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $tabla->integer('empleado_id')->unsigned()->nullable();
            $tabla->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');

            $tabla->integer('edo_ctsxcobrar_id')->unsigned()->nullable();
            $tabla->foreign('edo_ctsxcobrar_id')->references('id')->on('estados_ctsx_cobrar')->onDelete('cascade');
            
            $tabla->integer('tienda_id')->unsigned()->nullable();
            $tabla->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('cascade');

            
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
        Schema::drop('ctsx_cobrar_maestro');
    }
}
