<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedDepartamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('departamentos')->insert(
            array(
                array('cod_depto' => '01','departamento' => 'Guatemala'),
                array('cod_depto' => '02','departamento' => 'El Progreso'),
                array('cod_depto' => '03','departamento' => 'Sacatepéquez'),
                array('cod_depto' => '04','departamento' => 'Chimaltenango'),
                array('cod_depto' => '05','departamento' => 'Escuintla'),
                array('cod_depto' => '06','departamento' => 'Santa Rosa'),
                array('cod_depto' => '07','departamento' => 'Sololá'),
                array('cod_depto' => '08','departamento' => 'Totonicapán'),
                array('cod_depto' => '09','departamento' => 'Quetzaltenango'),
                array('cod_depto' => '10','departamento' => 'Suchitepéquez'),
                array('cod_depto' => '11','departamento' => 'Retalhuleu'),
                array('cod_depto' => '12','departamento' => 'San Marcos'),
                array('cod_depto' => '13','departamento' => 'Huehuetenango'),
                array('cod_depto' => '14','departamento' => 'Quiché'),
                array('cod_depto' => '15','departamento' => 'Baja Verapaz'),
                array('cod_depto' => '16','departamento' => 'Alta Verapaz'),
                array('cod_depto' => '17','departamento' => 'Petén'),
                array('cod_depto' => '18','departamento' => 'Izabal'),
                array('cod_depto' => '19','departamento' => 'Zacapa'),
                array('cod_depto' => '20','departamento' => 'Chiquimula'),
                array('cod_depto' => '21','departamento' => 'Jalapa'),
                array('cod_depto' => '22','departamento' => 'Jutiapa'),
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
        DB::table('departamentos')->delete();
    }
}
