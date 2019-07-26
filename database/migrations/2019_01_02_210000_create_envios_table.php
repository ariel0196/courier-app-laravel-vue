<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnviosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$estadosEnvio = Config::get('data.estados_envio');

		Schema::create('envios', function (Blueprint $table) use ($estadosEnvio) {
			$table->increments('id');

			$table->unsignedInteger('cliente_origen_id');
			$table->unsignedInteger('ciudad_origen_id')->nullable();
			$table->unsignedInteger('direccion_origen_id')->nullable();
			$table->string('direccion_origen_opc')->nullable();

			$table->unsignedInteger('cliente_destino_id')->nullable();
			$table->string('cliente_destino_opc')->nullable();
			$table->unsignedInteger('ciudad_destino_id');
			$table->unsignedInteger('direccion_destino_id')->nullable();
			$table->string('direccion_destino_opc')->nullable();

			$table->unsignedInteger('tipo_envio_id');
			$table->unsignedInteger('repartidor_id')->nullable();
			$table->unsignedInteger('factura_id')->nullable();

			$table->json('paquetes');
			$table->float('peso_total_kg');
			$table->decimal('precio_total', 20, 2);

			$table->enum('estado', $estadosEnvio)->default($estadosEnvio[0]);
			$table->timestamp('fecha_creacion')->useCurrent();
			$table->timestamp('fecha_recogida')->nullable();
			$table->timestamp('fecha_entrega')->nullable();

			$table->foreign('cliente_origen_id')->references('id')->on('clientes');
			$table->foreign('ciudad_origen_id')->references('id')->on('ciudades');
			$table->foreign('direccion_origen_id')->references('id')->on('direcciones');
			$table->foreign('cliente_destino_id')->references('id')->on('clientes');
			$table->foreign('ciudad_destino_id')->references('id')->on('ciudades');
			$table->foreign('direccion_destino_id')->references('id')->on('direcciones');
			$table->foreign('tipo_envio_id')->references('id')->on('tipo_envios');
			$table->foreign('repartidor_id')->references('id')->on('repartidores');
			$table->foreign('factura_id')->references('id')->on('facturas');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('envios');
	}
}
