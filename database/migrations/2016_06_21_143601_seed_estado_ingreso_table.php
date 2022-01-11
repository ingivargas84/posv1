<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedEstadoIngresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('estado_ingresos')->insert(
            array(
                array('edo_ingreso' => 'Activo'),
                array('edo_ingreso' => 'Anulado'),
                array('edo_ingreso' => 'Eliminado'),
                )
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('estado_ingresos')->delete();
    }
}
