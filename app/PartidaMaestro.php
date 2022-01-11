<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartidaMaestro extends Model
{
	protected $table='partidas_maestro';

	protected $fillable=[
	'id',
	'fecha_partida',
	'total_ingreso',
	'total_salida',
	'saldo',
	'user_id'
	];

	public function user(){
		return $this->belongsTo('App\User');
	}

	public function partidaajuste(){
		return $this->hasMany('App\PartidaAjuste', 'partida_maestro_id', 'id');
	}
}
