<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresoDetalle extends Model
{
    protected $table='ingresos_detalle';

    protected $fillable=[
    'id',
    'fecha_ingreso',
    'producto_id',
    'precio_compra',
    'precio_venta',
    'existencias',
    'user_id',
    'ingreso_maestro_id',
    'movimiento_producto_id'
    ];

    public function producto(){
    	return $this->belongsTo('App\Producto');
    }

    public function movimientoproducto(){
        return $this->belongsTo('App\MovimientoProducto');
    }

    public function ingresomaestro(){
    	return $this->belongsTo('App\IngresoMaestro');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
