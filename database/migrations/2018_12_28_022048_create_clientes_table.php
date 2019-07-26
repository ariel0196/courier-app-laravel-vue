<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$tiposCliente = Config::get('data.tipos_cliente');
		Schema::create('clientes', function (Blueprint $table) use ($tiposCliente) {
			$table->increments('id');
			$table->string('nombre', '100');
			$table->enum('tipo', $tiposCliente)->default($tiposCliente[0]);
			$table->string('documento', '50')->nullable();
			$table->string('email', '80')->nullable();
			$table->string('celular', '30')->nullable();
			$table->string('telefono', '80')->nullable();
			$table->boolean('mayorista')->default(false);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('clientes');
	}
}
