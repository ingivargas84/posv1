<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiposMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_movimientos', function($tabla)
        {
            $tabla->increments('id');
            $tabla->string('tipo_movimiento',30);
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
        Schema::drop('tipos_movimientos');
    }
}