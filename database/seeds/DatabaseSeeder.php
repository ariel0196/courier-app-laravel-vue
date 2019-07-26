<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DepartamentosTableSeeder::class, // Departamentos y Ciudades
            ClientesTableSeeder::class, // Clientes y Direcciones
            RepartidoresTableSeeder::class, // Repartidores
            TipoEnviosTableSeeder::class, // Tipos De Envio
            EnviosTableSeeder::class, // Envios
            FacturasTableSeeder::class, // Facturas
            UsuariosTableSeeder::class // Usuarios
        ]);
    }
}

