<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function($tabla)
        {
            $tabla->increments('id');
            $tabla->string('codigobarra',50);
            $tabla->string('prod_nombre',50);
            $tabla->string('descripcion',50);
            $tabla->integer('porcentaje_ganancia');
            $tabla->integer('minimo');

            $tabla->integer('tienda_id')->unsigned()->nullable();
            $tabla->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('cascade');
            $tabla->float('precio_venta');
            $tabla->integer('edo_producto_id')->unsigned()->nullable();
            $tabla->foreign('edo_producto_id')->references('id')->on('estado_productos')->onDelete('cascade');

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
        Schema::drop('productos');
    }
}
