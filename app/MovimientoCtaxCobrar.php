<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoCtaxCobrar extends Model
{
    protected $table='movimientos_ctaxcobrar';

    protected $fillable=[
    'id',
    'empleado_id',
    'fecha_movimiento',
    'tipo_movimiento_id',
    'monto',
    'saldo',
    'user_id',
    ];

    public function empleado(){
    	return $this->belongsTo('App\Empleado');
    }

    public function tipomovimiento(){
    	return $this->belongsTo('App\Tipo_Movimiento');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
