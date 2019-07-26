<?php

use Illuminate\Database\Seeder;
use App\Cliente;

class TipoEnviosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     	App\TipoEnvio::insert([
            [ 'nombre' => 'Normal', 'precio_kg' => 10000 ],
            [ 'nombre' => 'Express', 'precio_kg'=> 20000 ]
        ]);
	}
}

