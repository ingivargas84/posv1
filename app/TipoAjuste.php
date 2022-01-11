<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoAjuste extends Model
{
    protected $table='tipos_ajustes';

    protected $fillable=[
    'id',
    'tipo_ajuste'
    ];

    public function partidaajuste(){
    	return $this->hasMany('App\PartidaAjuste');
    }
}
