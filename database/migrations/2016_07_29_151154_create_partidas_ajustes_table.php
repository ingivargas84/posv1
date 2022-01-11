<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartidasAjustesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('partidas_ajustes', function($tabla)
        {
            $tabla->increments('id');
            $tabla->date('fecha_ajuste');

            $tabla->integer('partida_maestro_id')->unsigned()->nullable();
            $tabla->foreign('partida_maestro_id')->references('id')->on('partida_maestro')->onDelete('cascade');
            
            $tabla->integer('producto_id')->unsigned()->nullable();
            $tabla->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            $tabla->integer('cantidad_ajuste');
            $tabla->float('precio_costo');
            $tabla->float('ingreso');
            $tabla->float('salida');

            $tabla->integer('user_id')->unsigned()->nullable();
            $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $tabla->integer('movimiento_producto_id')->unsigned()->nullable();
            $tabla->foreign('movimiento_producto_id')->references('id')->on('movimientos_productos')->onDelete('cascade');

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
        Schema::drop('partidas_ajustes');
    }
}
