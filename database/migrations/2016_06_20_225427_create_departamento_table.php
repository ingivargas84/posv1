<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departamentos', function($tabla)
        {
            $tabla->increments('id');
            $tabla->string('cod_depto',2);
            $tabla->string('departamento',15);
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
        Schema::drop('departamentos');
    }
}
