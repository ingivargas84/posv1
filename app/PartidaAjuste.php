<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartidaAjuste extends Model
{
     protected $table='partidas_ajustes';

    protected $fillable=[
    'id',
    'partida_maestro_id',
    'producto_id',
    'cantidad_ajuste',
    'precio_costo',
    'ingreso',
    'salida',
    'user_id',
    'movimiento_producto_id'
    ];

    public function producto(){
    	return $this->belongsTo('App\Producto');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function partidamaestro(){
        return $this->belongsTo('App\PartidaMaestro', 'id', 'partida_maestro_id');
    }
}
