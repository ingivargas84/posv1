<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedTiposMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tipos_movimientos')->insert(
            array(
                array('tipo_movimiento' => 'Cargo'),
                array('tipo_movimiento' => 'Abono'),
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
        DB::table('tipos_movimientos')->delete();
    }
}
