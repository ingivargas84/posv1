<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CtaxCobrarDetalle extends Model
{
    protected $table='ctsx_cobrar_detalle';

    protected $fillable=[
    'id',
    'ctsx_cobrar_id',
    'producto_id',
    'cantidad',
    'precio_compra',
    'precio_venta',
    'subtotal'
    
    ];

    public function producto(){
    	return $this->belongsTo('App\Producto');
    }

    public function ctaxcobrarmaestro(){
    	return $this->belongsTo('App\Ctaxcobrarmaestro', "ctsx_cobrar_id", "id");
    }
}
