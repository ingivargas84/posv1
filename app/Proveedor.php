<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table='proveedores';

    protected $fillable=[
    'id',
    'nit',
    'nombre_comercial',
    'nombre_contable',
    'telefonos'
    ];

    public function ingresoproducto(){
    	return $this->hasMany('App\IngresoProducto');
    }
}
