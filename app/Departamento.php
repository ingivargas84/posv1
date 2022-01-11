<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table='departamentos';

    protected $fillable=[
    'id',
    'cod_depto',
    'departamento'
    ];

    public function municipio(){
    	return $this->hasMany('App\Municipio');
    }
}
