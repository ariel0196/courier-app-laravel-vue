<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
	public $timestamps = false;
	protected $fillable = [
		'nombre', 
		'descripción'
	];

	public function ciudades() {
		return $this->hasMany(Ciudad::class);
	}
}
