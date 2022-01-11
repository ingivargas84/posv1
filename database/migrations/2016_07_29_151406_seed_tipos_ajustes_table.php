<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedTiposAjustesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tipos_ajustes')->insert(
            array(
                array('tipo_ajuste' => 'Venta'),
                array('tipo_ajuste' => 'Compra'),
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
        DB::table('tipos_ajustes')->delete();
    }
}
