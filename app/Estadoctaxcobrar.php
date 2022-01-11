<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estadoctaxcobrar extends Model
{
    protected $table='estados_ctsx_cobrar';

    protected $fillable=[
    'id',
    'edo_ctsx_cobrar'
    ];

    public function ctaxcobrarmaestro(){
    	return $this->hasMany('App\Ctaxcobrarmaestro');
    }
}
