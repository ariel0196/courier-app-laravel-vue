<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
	public $timestamps = false;
	protected $fillable = [
		'nombre',
		'tipo',
		'documento',
		'email',
		'celular',
		'telefono',
		'mayorista'
	];

	public function direcciones() {
		return $this->hasMany(Direccion::class);
	}

	public function enviosOrigen() {
		return $this->hasMany(Envio::class, 'cliente_origen_id');
	}

	public function enviosDestino() {
		return $this->hasMany(Envio::class, 'cliente_destino_id');
	}

	public function usuarios () {
		return $this->hasMany(Usuario::class);
	}
}
