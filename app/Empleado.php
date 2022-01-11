<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table='empleados';

    protected $fillable=[
    'id',
    'emp_cui',
    'emp_nombres',
    'emp_apellidos',
    'emp_direccion',
    'emp_telefonos',
    'cargo_id',
    'tienda_id',
    'edo_empleado_id',
    'user_id'
    ];

    public function tienda(){
    	return $this->belongsTo('App\Tienda');
    }

    public function estadoempleado(){
    	return $this->belongsTo('App\EstadoEmpleado');
    }

    public function cargo(){
    	return $this->belongsTo('App\Cargo');
    }

    public function user(){
    	return $this->hasMany('App\User');
    }

    public function ctaxcobrarmaestro(){
    	return $this->hasMany('App\Ctaxcobrarmaestro');
    }

    public function movimientoctaxcobrar(){
        return $this->hasMany('App\MovimientoCtaxCobrar');
    }
}
