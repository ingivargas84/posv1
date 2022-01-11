<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMovimiento extends Model
{
    protected $table='tipos_movimientos';

    protected $fillable=[
    'id',
    'tipo_movimiento'
    ];

    public function movimientoctaxcobrar()){
    	return $this->hasMany('App\MovimientoCtaxCobrar');
    }
}
