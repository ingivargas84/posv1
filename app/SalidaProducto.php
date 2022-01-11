<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SalidaProducto extends Model
{
    protected $table='salidas_productos';

    protected $fillable=[
    'id',
    'producto_id',
    'cantidad_salida',
    'fecha_salida',
    'user_id',
    'tipo_salida_id',
    'razon_salida',
    'movimiento_producto_id'
    ];

    public function producto(){
    	return $this->belongsTo('App\Producto');
    }

    public function movimientoproducto(){
        return $this->belongsTo('App\MovimientoProducto');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function tiposalida(){
    	return $this->belongsTo('App\TipoSalida');
    }

    public function getFechaSalidaAttribute ($value) 
    {
        if ( $value != NULL )
        {
            return Carbon::parse($value)->format('d-m-Y');
        }
        else 
        {
            $value = "";
            return $value;
        }
    }
}
