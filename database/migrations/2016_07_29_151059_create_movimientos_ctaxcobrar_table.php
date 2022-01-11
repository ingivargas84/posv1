<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosCtaxcobrarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos_ctaxcobrar', function($tabla)
        {
            $tabla->increments('id');
            
            $tabla->integer('empleado_id')->unsigned()->nullable();
            $tabla->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');

            $tabla->date('fecha_movimiento');

            $tabla->integer('tipo_movimiento_id')->unsigned()->nullable();
            $tabla->foreign('tipo_movimiento_id')->references('id')->on('tipos_movimientos')->onDelete('cascade');

            $tabla->float('monto');
            $tabla->float('saldo');

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
        Schema::drop('movimientos_ctaxcobrar');
    }
}
