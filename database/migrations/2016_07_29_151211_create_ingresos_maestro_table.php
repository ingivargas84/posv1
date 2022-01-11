<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresosMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_maestro', function($tabla)
        {
            $tabla->increments('id');
            
            $tabla->integer('user_id')->unsigned()->nullable();
            $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $tabla->date('fecha_factura');

            $tabla->integer('proveedor_id')->unsigned()->nullable();
            $tabla->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');

            $tabla->string('serie_factura',20);
            $tabla->string('num_factura',30);
            $tabla->float('total_factura');

            $tabla->integer('edo_ingreso_id')->unsigned()->nullable();
            $tabla->foreign('edo_ingreso_id')->references('id')->on('estado_ingresos')->onDelete('cascade');

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
        Schema::drop('ingresos_maestro');
    }
}
