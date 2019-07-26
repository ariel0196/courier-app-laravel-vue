<?php

use Illuminate\Database\Seeder;

class FacturasTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker\Factory::create();
		$tiposPago = Config::get('data.tipos_pago');

		$clientes = App\Cliente::query()
			->has('enviosOrigen')
			->get();

		foreach ($clientes as $cliente) {

			$envios = $cliente->enviosOrigen()->get();

			$montoTotal = 0;

			foreach ($envios as $envio) {

				$montoTotal += $envio->precio_total;
				$envio->estado = 'cobrado';
				$envio->fecha_recogida = $faker->dateTimeInInterval($envio->fecha_creacion, '+5 days');
				$envio->fecha_entrega = $faker->dateTimeInInterval($envio->fecha_recogida, '+5 days');
			}

			$factura = factory(App\Factura::class)->make();

			$factura->cliente_id = $cliente->id;
			$factura->estado = 'cobrada';
			$factura->monto_total = $montoTotal;
			$factura->tipo_pago = $faker->randomElement($tiposPago);
			$factura->fecha_cobro = $faker->dateTimeBetween($envio->fecha_creacion, '+10 days');

			$factura->save();
			$factura->envios()->saveMany($envios);
		}
	}
}
