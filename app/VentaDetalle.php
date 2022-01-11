<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    protected $table='ventas_detalle';

    protected $fillable=[
    'id',
    'venta_id',
    'producto_id',
    'cantidad',
    'precio_compra',
    'precio_venta',
    'movimiento_producto_id',
    'subtotal'
    ];

    public function ventamaestro(){
    	return $this->belongsTo('App\VentaMaestro', "venta_id", "id");
    }

    public function producto(){
    	return $this->belongsTo('App\Producto');
    }

    public function movimientoproducto(){
        return $this->belongsTo('App\MovimientoProducto');
    }
}
