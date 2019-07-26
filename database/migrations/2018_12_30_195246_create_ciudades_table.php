<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiudadesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ciudades', function (Blueprint $table) {
			$table->increments('id');
			$table->string('nombre');
			$table->string('descripcion')->nullable();
			$table->unsignedInteger('departamento_id');
			$table->unsignedInteger('tiempo_estimado')->nullable();

			$table->foreign('departamento_id')->references('id')->on('departamentos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ciudades');
	}
}
