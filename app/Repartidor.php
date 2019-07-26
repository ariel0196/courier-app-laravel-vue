<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repartidor extends Model
{
	public $timestamps = false;
	protected $table = 'repartidores';
	protected $fillable = [
		'nombre'
	];

	public function envios() {
		return $this->hasMany(Envio::class);
	}
}