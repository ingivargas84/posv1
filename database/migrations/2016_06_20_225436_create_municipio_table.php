<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMunicipioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipios', function($tabla)
        {
            $tabla->increments('id');
            $tabla->string('cod_mpio',4);
            $tabla->string('municipio',50);

            $tabla->integer('departamento_id')->unsigned()->nullable();
            $tabla->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('cascade');
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
        Schema::drop('municipios');
    }
}
