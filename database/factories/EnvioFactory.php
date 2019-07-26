<?php

use Faker\Generator as Faker;


$factory->define(App\Envio::class, function (Faker $faker) {

	$clienteOrigen = App\Cliente::query()
		->with('direcciones.ciudad')
		->inRandomOrder()
		->first();
	$direccionOrigen = $clienteOrigen->direcciones->random();
	$ciudadOrigen = $direccionOrigen->ciudad;

	$clienteDestino = App\Cliente::query()
		->with('direcciones.ciudad')
		->inRandomOrder()
		->first();
	$direccionDestino = $clienteDestino->direcciones->random();
	$ciudadDestino = $direccionDestino->ciudad;

	$tipoEnvio = App\TipoEnvio::query()
		->inRandomOrder()
		->first();

	$repartidor = App\Repartidor::query()
		->inRandomOrder()
		->first();

	$paquetes = [];
	$pesoTotalKg = 0;
	$cantPaquetes = $faker->numberBetween(2, 5);
	$tiposPaquete = Config::get('data.tipos_paquete');

	for ($i = 1; $i <= $cantPaquetes; $i++) {
		$pesoKg = $faker->numberBetween(1, 10);
		$pesoTotalKg += $pesoKg;
		$paquetes[] = [
			'nombre' => $faker->sentence(2),
			'tipo_paquete' => $faker->randomElement($tiposPaquete),
			'peso_kg' => $pesoKg
		];
	}

	return [
		'cliente_origen_id' => $clienteOrigen->id,
		'direccion_origen_id' => $direccionOrigen->id,
		'ciudad_origen_id' => $ciudadOrigen->id,

		'cliente_destino_id' => $clienteDestino->id,
		'direccion_destino_id' => $direccionDestino->id,
		'ciudad_destino_id' => $ciudadDestino->id,

		'tipo_envio_id' => $tipoEnvio->id,
		'repartidor_id' => $repartidor->id,

		'paquetes' => $paquetes,
		'peso_total_kg' => $pesoTotalKg,
		'precio_total' => $pesoTotalKg * $tipoEnvio->precio_kg
	];
});
