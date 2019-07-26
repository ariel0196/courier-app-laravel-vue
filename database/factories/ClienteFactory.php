<?php

use Faker\Generator as Faker;

$factory->define(App\Cliente::class, function (Faker $faker) {

	$tiposCliente = Config::get('data.tipos_cliente');

	return [
		'nombre' => $faker->name,
		'tipo' => $faker->randomElement($tiposCliente),
		'documento' => $faker->randomNumber(7),
		'email' => $faker->email,
		'celular' => '+595981' . $faker->randomNumber(6),
		'telefono' => '+59521' . $faker->randomNumber(6),
		'mayorista' => $faker->boolean()
	];
});
