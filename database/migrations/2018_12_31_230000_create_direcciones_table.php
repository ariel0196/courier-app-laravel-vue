<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDireccionesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('direcciones', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('cliente_id');
			$table->unsignedInteger('ciudad_id');
			$table->string('descripcion');

			$table->foreign('cliente_id')->references('id')->on('clientes');
			$table->foreign('ciudad_id')->references('id')->on('ciudades');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('direcciones');
	}
}
