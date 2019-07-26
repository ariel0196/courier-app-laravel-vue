<?php

use Faker\Generator as Faker;

$factory->define(App\Factura::class, function (Faker $faker) {

	return [
		'numero' => $faker->numberBetween(1000, 10000)
		// 'cliente_id' => function () {
		// 	$found = false;
		// 	while (!$found) {
		// 		$cliente = App\Cliente::query()
		// 			->inRandomOrder()
		// 			->first();
		// 		$found = ($cliente->enviosOrigen()->count() > 0);
		// 	}
		// 	return $cliente->id;
		// }
	];
});
