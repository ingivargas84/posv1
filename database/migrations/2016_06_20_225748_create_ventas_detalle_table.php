<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_detalle', function($tabla)
        {
            $tabla->increments('id');

            $tabla->integer('venta_id')->unsigned()->nullable();
            $tabla->foreign('venta_id')->references('id')->on('ventas_maestro')->onDelete('cascade');

            $tabla->integer('producto_id')->unsigned()->nullable();
            $tabla->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            $tabla->integer('cantidad');
            $tabla->float('precio_compra');
            $tabla->float('precio_venta');
            $tabla->float('subtotal');

            $tabla->integer('movimiento_producto_id');
            
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
        Schema::drop('ventas_detalle');
    }
}
