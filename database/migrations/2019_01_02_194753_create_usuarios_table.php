<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		$roles = Config::get('data.roles');

		Schema::create('usuarios', function (Blueprint $table) use ($roles) {
			$table->increments('id');
			$table->string('nombre');
			$table->string('email')->unique();
			$table->string('password');
			$table->string('token')->nullable();
			$table->enum('rol', $roles)->default($roles[0]);
			$table->unsignedInteger('cliente_id')->nullable();
		});
	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		Schema::dropIfExists('usuarios');
	}
}
