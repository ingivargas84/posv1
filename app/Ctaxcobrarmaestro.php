<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ctaxcobrarmaestro extends Model
{
    protected $table='ctsx_cobrar_maestro';

    protected $fillable=[
    'id',
    'fecha',
    'total_x_cobrar',
    'user_id',
    'empleado_id',
    'edo_ctsxcobrar_id',
    'tienda_id'
    ];

    public function estadoctaxcobrar(){
    	return $this->belongsTo('App\Estadoctaxcobrar');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function empleado(){
    	return $this->belongsTo('App\Empleado');
    }

    public function tienda(){
    	return $this->belongsTo('App\Tienda');
    }

    public function ctaxcobrardetalle(){
    	return $this->hasMany('App\CtaxCobrarDetalle', "ctsx_cobrar_id", "id");
    }
}
