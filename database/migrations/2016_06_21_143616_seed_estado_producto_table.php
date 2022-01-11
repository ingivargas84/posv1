<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedEstadoProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('estado_productos')->insert(
            array(
                array('edo_producto' => 'Activo'),
                array('edo_producto' => 'Vencido'),
                array('edo_producto' => 'Mínimo'),
                array('edo_producto' => 'Agotado'),
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
        DB::table('estado_productos')->delete();
    }
}
