<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class IngresoProducto extends Model
{
	protected $table='ingresos_productos';

	protected $fillable=[
	'id',
	'producto_id',
	'cantidad_ingreso',
	'fecha_ingreso',
	'user_id',
	'edo_ingreso_id',
	'serie_factura',
	'num_factura',
	'fecha_factura',
	'proveedor_id'
	];

	public function producto(){
		return $this->belongsTo('App\Producto');
	}

	public function user(){
		return $this->belongsTo('App\User');
	}

	public function estadoingreso(){
		return $this->belongsTo('App\EstadoIngreso');
	}

	public function proveedor(){
		return $this->belongsTo('App\Proveedor');
	}

	public function getFechaFacturaAttribute ($value) 
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

		public function getFechaIngresoAttribute ($value) 
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
