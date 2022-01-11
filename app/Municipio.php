<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table='municipios';

    protected $fillable=[
    'id',
    'cod_mpio',
    'municipio',
    'departamento_id'
    ];

    public function tienda(){
    	return $this->hasMany('App\Tienda');
    }

    public function departamento(){
    	return $this->belongsTo('App\Departamento');
    }
}
