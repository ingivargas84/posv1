<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VentaMaestro extends Model
{
    protected $table='ventas_maestro';

    protected $fillable=[
    'id',
    'tipo_venta_id',
    'total_venta',
    'user_id',
    'edo_venta_id'
    ];

    public function tipoventa(){
    	return $this->belongsTo('App\TipoVenta');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function estadoventa(){
    	return $this->belongsTo('App\EstadoVenta');
    }

    public function ventadetalle(){
    	return $this->hasMany('App\VentaDetalle', "venta_id", "id");
    }
}
