<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedEstadoCtsxCobrarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('estados_ctsx_cobrar')->insert(
            array(
                array('edo_ctsx_cobrar' => 'Por Cobrar'),
                array('edo_ctsx_cobrar' => 'Liquidado'),
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
        DB::table('estados_ctsx_cobrar')->delete();
    }
}
