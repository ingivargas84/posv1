<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalidasProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salidas_productos', function($tabla)
        {
            $tabla->increments('id');

            $tabla->integer('producto_id')->unsigned()->nullable();
            $tabla->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            $tabla->integer('cantidad_salida');
            $tabla->date('fecha_salida');
            
            $tabla->integer('user_id')->unsigned()->nullable();
            $tabla->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $tabla->integer('tipo_salida_id')->unsigned()->nullable();
            $tabla->foreign('tipo_salida_id')->references('id')->on('tipos_salida')->onDelete('cascade');

            $tabla->string('razon_salida',200);
            
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
        Schema::drop('salidas_productos');
    }
}
