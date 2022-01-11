<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresoProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_productos', function($tabla)
        {
            $tabla->increments('id');

            $tabla->integer('producto_id')->unsigned()->nullable();
            $tabla->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            $tabla->integer('cantidad_ingreso');
            $tabla->date('fecha_ingreso');
            
            $tabla->integer('user_id')->unsigned()->nullable();
            $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $tabla->integer('edo_ingreso_id')->unsigned()->nullable();
            $tabla->foreign('edo_ingreso_id')->references('id')->on('estado_ingresos')->onDelete('cascade');

            $tabla->string('serie_factura',3);
            $tabla->integer('num_factura');
            $tabla->date('fecha_factura');
            
            $tabla->integer('proveedor_id')->unsigned()->nullable();
            $tabla->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');
            
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
        Schema::drop('ingresos_productos');
    }
}
