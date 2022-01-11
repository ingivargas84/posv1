<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresosDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_detalle', function($tabla)
        {
            $tabla->increments('id');
            $tabla->date('fecha_ingreso');
            
            $tabla->integer('producto_id')->unsigned()->nullable();
            $tabla->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            $tabla->float('precio_compra');
            $tabla->float('precio_venta');
            $tabla->integer('existencias');

            $tabla->integer('user_id')->unsigned()->nullable();
            $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $tabla->integer('ingreso_maestro_id')->unsigned()->nullable();
            $tabla->foreign('ingreso_maestro_id')->references('id')->on('ingresos_maestro')->onDelete('cascade');

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
        Schema::drop('ingresos_detalle');
    }
}
