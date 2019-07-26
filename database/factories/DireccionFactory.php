<?php

use Faker\Generator as Faker;

$factory->define(App\Direccion::class, function (Faker $faker) {

	return [
		'descripcion' => $faker->streetAddress(),
		'ciudad_id' => function () {
			return App\Ciudad::query()->inRandomOrder()->first()->id;
		}
	];
});
