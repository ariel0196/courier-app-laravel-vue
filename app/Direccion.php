<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
	public $timestamps = false;
	protected $table = 'direcciones';
	protected $fillable = [
		'cliente_id',
		'ciudad_id',
		'descripcion'
	];

	public function cliente() {
		return $this->belongsTo(Cliente::class);
	}

	public function ciudad() {
		return $this->belongsTo(Ciudad::class);
	}
}
