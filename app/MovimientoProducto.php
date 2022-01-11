<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoProducto extends Model
{
    protected $table='movimientos_productos';

    protected $fillable=[
    'id',
    'fecha_ingreso',
    'producto_id',
    'existencias',
    'precio_compra',
    'precio_venta'
    ];

    public function producto(){
        return $this->belongsTo('App\Producto');
    }

    public function ingresomaestro(){
        return $this->belongsTo('App\IngresoMaestro');
    }

    public function ingresodetalle(){
        return $this->hasMany('App\IngresoDetalle');
    }

    public function ventadetalle(){
        return $this->hasMany('App\VentaDetalle');
    }

    public function salidaproducto(){
        return $this->hasMany('App\SalidaProducto');
    }

}
