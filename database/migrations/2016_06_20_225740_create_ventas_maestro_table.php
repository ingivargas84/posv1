<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_maestro', function($tabla)
        {
            $tabla->increments('id');
            
            $tabla->integer('tipo_venta_id')->unsigned()->nullable();
            $tabla->foreign('tipo_venta_id')->references('id')->on('tipo_ventas')->onDelete('cascade');

            $tabla->float('subtotal_venta');
            $tabla->float('iva_venta');
            $tabla->float('total_venta');

            $tabla->integer('user_id')->unsigned()->nullable();
            $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $tabla->integer('edo_venta_id')->unsigned()->nullable();
            $tabla->foreign('edo_venta_id')->references('id')->on('estado_ventas')->onDelete('cascade');

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
        Schema::drop('ventas_maestro');
    }
}
