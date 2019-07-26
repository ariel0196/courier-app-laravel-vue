<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
	protected $casts = [
		'fecha_creacion' => 'datetime:Y-m-d',
		'fecha_cobro' => 'datetime:Y-m-d'
	];

	protected $table = 'facturas';

	public $timestamps = false;

	protected $fillable = [
		'numero',
		'cliente_id',
		'tipo_pago',
		'monto_total',
		'estado',
		'fecha_creacion',
		'fecha_cobro'
	];

	public function envios() {
		return $this->hasMany(Envio::class);
	}

	public function cliente() {
		return $this->belongsTo(Cliente::class);
	}
}
