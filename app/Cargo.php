<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table='cargos';

    protected $fillable=[
    'id',
    'cargo',
    ];

    public function empleado(){
    	return $this->hasMany('App\Empleado');
    }
}
