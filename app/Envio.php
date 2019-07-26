<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
	protected $casts = [
		'fecha_creacion' => 'datetime:Y-m-d',
		'fecha_recogida' => 'datetime:Y-m-d',
		'fecha_entrega' => 'datetime:Y-m-d',
		'paquetes' => 'array'
	];

	public $timestamps = false;
	protected $fillable = [
		'cliente_origen_id',
		'ciudad_origen_id',
		'direccion_origen_id',
		'direccion_origen_opc',

		'cliente_destino_id',
		'cliente_destino_opc',
		'ciudad_destino_id',
		'direccion_destino_id',
		'direccion_destino_opc',

		'tipo_envio_id',
		'repartidor_id',
		'factura_id',

		'paquetes',
		'peso_total_kg',
		'precio_total',
		'estado',

		'fecha_recogida',
		'fecha_entrega'
	];

	public function clienteOrigen() {
		return $this->belongsTo(Cliente::class);
	}

	public function ciudadOrigen() {
		return $this->belongsTo(Ciudad::class);
	}

	public function direccionOrigen() {
		return $this->belongsTo(Direccion::class);
	}

	public function clienteDestino() {
		return $this->belongsTo(Cliente::class);
	}

	public function ciudadDestino() {
		return $this->belongsTo(Ciudad::class);
	}

	public function direccionDestino() {
		return $this->belongsTo(Direccion::class);
	}

	public function tipoEnvio() {
		return $this->belongsTo(TipoEnvio::class);
	}

	public function repartidor() {
		return $this->belongsTo(Repartidor::class);
	}

	public function factura() {
		return $this->belongsTo(Factura::class);
	}

}
