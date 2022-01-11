<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoEmpleado extends Model
{
    protected $table='estado_empleados';

    protected $fillable=[
    'id',
    'edo_empleado'
    ];

    public function empleado(){
    	return $this->hasMany('App\Empleado');
    }
}
