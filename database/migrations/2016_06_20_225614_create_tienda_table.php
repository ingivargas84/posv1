<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiendas', function($tabla)
        {
            $tabla->increments('id');
            $tabla->string('nombre',35);
            $tabla->string('telefonos',35);
            $tabla->string('direccion',40);

            $tabla->integer('municipio_id')->unsigned()->nullable();
            $tabla->foreign('municipio_id')->references('id')->on('municipios')->onDelete('cascade');
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
        Schema::drop('tiendas');
    }
}
