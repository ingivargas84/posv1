<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresoMaestro extends Model
{
    protected $table='ingresos_maestro';

    protected $fillable=[
    'id',
    'user_id',
    'fecha_factura',
    'proveedor_id',
    'serie_factura',
    'num_factura',
    'total_factura',
    'edo_ingreso_id'
    ];

    public function ingresodetalle(){
    	return $this->hasMany('App\IngresoDetalle');
    }

    public function movimientoproducto(){
        return $this->hasMany('App\MovimientoProducto');
    }

    public function proveedor(){
    	return $this->belongsTo('App\Proveedor');
    }

    public function estadoingreso(){
    	return $this->belongsTo('App\EstadoIngreso');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
