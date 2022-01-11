<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedTiendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tiendas')->insert(
            array(
                array('nombre' => 'Market Teculutan','direccion' => 'Km 121.5 Carretera al Atlántico, Teculután', 'municipio_id' => 299),
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
        DB::table('tiendas')->delete();
    }
}
