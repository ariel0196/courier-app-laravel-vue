<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
	public $timestamps = false;
	protected $fillable = [
		'nombre',
		'email',
		'password',
		'rol',
		'token'
	];

	protected $hidden = [
		'password'
	];

	public function cliente() {
		return $this->belongsTo(Cliente::class);
	}
}
