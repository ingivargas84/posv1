<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table='productos';

    protected $fillable=[
    'id',
    'codigobarra',
    'prod_nombre',
    'descripcion',
    'porcentaje_ganancia',
    'minimo',
    'tienda_id',
    'edo_producto_id',
    'user_id',
    'existencias',
    'precio_compra',
    'precio_venta'
    ];

    public function tienda(){
    	return $this->belongsTo('App\Tienda');
    }

    public function estadoproducto(){
    	return $this->belongsTo('App\EstadoProducto');
    }

    public function ctaxcobrardetalle(){
    	return $this->hasMany('App\CtaxCobrarDetalle');
    }

    public function ventadetalle(){
    	return $this->hasMany('App\VentaDetalle');
    }

    public function salidaproducto(){
    	return $this->hasMany('App\SalidaProducto');
    }

    public function partidaajuste(){
        return $this->hasMany('App\PartidaAjuste');
    }

    public function ingresodetalle(){
        return $this->hasMany('App\IngresoDetalle');
    }

    public function ingresoproducto(){
    	return $this->hasMany('App\IngresoProducto');
    }
}
