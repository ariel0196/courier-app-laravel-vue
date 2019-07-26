<?php

use Faker\Generator as Faker;

$factory->define(App\Repartidor::class, function (Faker $faker) {

	return [
		'nombre' => $faker->name
	];
});
