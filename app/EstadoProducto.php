<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoProducto extends Model
{
    protected $table='estado_productos';

    protected $fillable=[
    'id',
    'edo_producto'
    ];

    public function producto(){
    	return $this->hasMany('App\Producto');
    }
}
