<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoVenta extends Model
{
    protected $table='tipo_ventas';

    protected $fillable=[
    'id',
    'tipo_venta'
    ];

    public function ventamaestro(){
    	return $this->hasMany('App\VentaMaestro');
    }
}
