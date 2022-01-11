<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtsxCobrarDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctsx_cobrar_detalle', function($tabla)
        {
            $tabla->increments('id');

            $tabla->integer('ctsx_cobrar_id')->unsigned()->nullable();
            $tabla->foreign('ctsx_cobrar_id')->references('id')->on('ctsx_cobrar_maestro')->onDelete('cascade');

            $tabla->integer('producto_id')->unsigned()->nullable();
            $tabla->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            $tabla->integer('cantidad');
            $tabla->float('precio_compra');
            $tabla->float('precio_venta');
            $tabla->float('subtotal');

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
        Schema::drop('ctsx_cobrar_detalle');
    }
}
