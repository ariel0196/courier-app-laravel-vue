<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
	public $timestamps = false;
	protected $table = 'ciudades';
	protected $fillable = [
		'nombre',
		'descripcion',
		'departamento_id',
		'tiempo_estimado'
		// 'precio_kg'
	];

	public function departamento() {
		return $this->belongsTo(Departamento::class);
	}

	public function direcciones() {
		return $this->hasMany(Direccion::class);
	}
}
