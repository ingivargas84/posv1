<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadoCtsxCobrarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estados_ctsx_cobrar', function($tabla)
        {
            $tabla->increments('id');
            $tabla->string('edo_ctsx_cobrar',30);
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
        Schema::drop('estados_ctsx_cobrar');
    }
}
