<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		factory(App\Cliente::class, 10)
			->create()
			->each(function ($cliente) {
				$cliente
					->direcciones()
					->saveMany(factory(App\Direccion::class, 10)->make());

				$usuario = new App\Usuario([
					'nombre' => $cliente->nombre,
					'email' => $cliente->email,
					'rol' => 'cliente'
				]);

				$usuario->password = Hash::make('root');

				$cliente->usuarios()->save($usuario);
			});
	}
}
