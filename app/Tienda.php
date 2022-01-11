<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    protected $table='tiendas';

    protected $fillable=[
    'id',
    'nombre',
    'telefonos',
    'direccion',
    'municipio_id'
    ];

    public function municipio(){
    	return $this->belongsTo('App\Municipio');
    }

    public function ctaxcobrarmaestro(){
    	return $this->hasMany('App\CtaxCobrarMaestro');
    }

    public function empleado(){
    	return $this->hasMany('App\Empleado');
    }

    public function proveedor(){
    	return $this->hasMany('App\Proveedor');
    }
}
