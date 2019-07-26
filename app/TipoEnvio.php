<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEnvio extends Model
{
	public $timestamps = false;
	protected $fillable = [
		'nombre', 
		'descripción',
		'precio_kg'
	];
}
