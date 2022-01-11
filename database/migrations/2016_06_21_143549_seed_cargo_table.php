<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCargoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('cargos')->insert(
            array(
                array('cargo' => 'Super Administrador'),
                array('cargo' => 'Administrador/Encargado'),
                array('cargo' => 'Vendedor/Cajero'),
                array('cargo' => 'Consulta'),
                array('cargo' => 'Financiero Central'),
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
        DB::table('cargos')->delete();
    }
}
