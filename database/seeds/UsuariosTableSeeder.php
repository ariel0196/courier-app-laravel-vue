<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		App\Usuario::insert([[
			'nombre' => 'cajero',
			'password' => Hash::make('root'),
			'email' => 'cajero@courier.com',
			'rol' => 'cajero'
		], [
			'nombre' => 'operador',
			'password' => Hash::make('root'),
			'email' => 'operador@courier.com',
			'rol' => 'operador'
		], [
			'nombre' => 'admin',
			'password' => Hash::make('root'),
			'email' => 'admin@courier.com',
			'rol' => 'administrador'
		]]);
	}
}
